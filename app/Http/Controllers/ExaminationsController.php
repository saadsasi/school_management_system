<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ExamModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamScheduleModel;
use App\Models\MarksRegisterModel;
use App\Models\AssignClassTeacherModel;
use App\Models\User;
use App\Models\MarksGradeModel;
use App\Models\SettingModel;

class ExaminationsController extends Controller
{
    public function exam_list()
    {
        $data['getRecord'] = ExamModel::getRecord();
        $data['header_title'] = "Exam List";
        return view('admin.examinations.exam.list',$data);
    }

    public function exam_add()
    {        
        $data['header_title'] = "Add New Exam";
        return view('admin.examinations.exam.add',$data);
    }

    public function exam_insert(Request $request)
    {
        $exam = new ExamModel;
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->created_by = Auth::user()->id;
        $exam->save();

        return redirect('admin/examinations/exam/list')->with('success', __('messages.exam_successfully_created'));
    }

    public function exam_edit($id)
    {
        $data['getRecord'] = ExamModel::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title'] = "Edit Exam";
            return view('admin.examinations.exam.edit',$data);    
        }
        else
        {
            abort(404);
        }
        
    }

    public function exam_update($id, Request $request)
    {
        $exam = ExamModel::getSingle($id);;
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->save();

        return redirect('admin/examinations/exam/list')->with('success', __('messages.exam_successfully_updated'));
    }

    public function exam_delete($id)
    {
        $getRecord = ExamModel::getSingle($id);
        if(!empty($getRecord))
        {
            $getRecord->is_delete = 1;
            $getRecord->save();

            return redirect()->back()->with('success', __('messages.exam_successfully_deleted'));
        }
        else
        {
            abort(404);
        }
        
    }

    public function exam_schedule(Request $request)
    {
        try {
            // Get unique grade levels where classes exist and are not deleted
            $data['getGradeLevels'] = ClassModel::select('grade_level')
                ->where('is_delete', 0)
                ->where('status', 0)
                ->whereNotNull('grade_level')
                ->groupBy('grade_level')
                ->orderBy('grade_level', 'asc')
                ->get();

            if($data['getGradeLevels']->isEmpty()) {
                return redirect()->back()->with('error', __('messages.no_grade_levels_found'));
            }

            $data['getExam'] = ExamModel::getExam();
            if($data['getExam']->isEmpty()) {
                return redirect()->back()->with('error', __('messages.no_exams_found'));
            }
            
            $result = array();
            if(!empty($request->get('exam_id')) && !empty($request->get('grade_level')))
            {
                // Validate if exam exists
                $examExists = ExamModel::where('id', $request->get('exam_id'))
                    ->where('is_delete', 0)
                    ->exists();
                if(!$examExists) {
                    return redirect()->back()->with('error', __('messages.exam_not_found'));
                }

                // Validate if grade level exists
                $gradeExists = ClassModel::where('grade_level', $request->get('grade_level'))
                    ->where('is_delete', 0)
                    ->where('status', 0)
                    ->exists();
                if(!$gradeExists) {
                    return redirect()->back()->with('error', __('messages.grade_level_not_found'));
                }

                // Get all subjects for this grade level
                $subjects = ClassSubjectModel::select('class_subject.*', 'subject.name as subject_name', 'subject.type as subject_type')
                    ->join('class', 'class_subject.class_id', '=', 'class.id')
                    ->join('subject', 'class_subject.subject_id', '=', 'subject.id')
                    ->where('class.grade_level', $request->get('grade_level'))
                    ->where('class.is_delete', 0)
                    ->where('class.status', 0)
                    ->groupBy('subject.id')
                    ->get();

                if($subjects->isEmpty()) {
                    return redirect()->back()->with('error', __('messages.no_subjects_found_for_grade'));
                }
                               
                foreach($subjects as $subject) {
                    $dataS = array();
                    $dataS['subject_id'] = $subject->subject_id;
                    $dataS['subject_name'] = $subject->subject_name;
                    $dataS['subject_type'] = $subject->subject_type;

                    // Get exam schedule for this subject in this grade level
                    $ExamSchedule = ExamScheduleModel::where('exam_id', $request->get('exam_id'))
                        ->where('subject_id', $subject->subject_id)
                        ->whereIn('class_id', function($query) use ($request) {
                            $query->select('id')
                                ->from('class')
                                ->where('grade_level', $request->get('grade_level'))
                                ->where('is_delete', 0)
                                ->where('status', 0);
                        })
                        ->first();

                    if(!empty($ExamSchedule)) {
                        $dataS['exam_date'] = $ExamSchedule->exam_date;
                        $dataS['start_time'] = $ExamSchedule->start_time;
                        $dataS['end_time'] = $ExamSchedule->end_time;
                        $dataS['room_number'] = $ExamSchedule->room_number;
                        $dataS['full_marks'] = $ExamSchedule->full_marks;
                        $dataS['passing_mark'] = $ExamSchedule->passing_mark;
                    } else {
                        $dataS['exam_date'] = '';
                        $dataS['start_time'] = '';
                        $dataS['end_time'] = '';
                        $dataS['room_number'] = '';
                        $dataS['full_marks'] = '';
                        $dataS['passing_mark'] = '';
                    }

                    $result[] = $dataS;
                }
            }

            $data['getRecord'] = $result;
            $data['header_title'] = "Exam Schedule";
            return view('admin.examinations.exam_schedule',$data);   

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.something_went_wrong'));
        }
    }

    public function exam_schedule_insert(Request $request)
    {
        try {
            // Validate required fields
            if(empty($request->exam_id) || empty($request->grade_level)) {
                return redirect()->back()->with('error', __('messages.exam_and_grade_required'));
            }

            // Validate if exam exists
            $examExists = ExamModel::where('id', $request->exam_id)
                ->where('is_delete', 0)
                ->exists();
            if(!$examExists) {
                return redirect()->back()->with('error', __('messages.exam_not_found'));
            }

            // Validate if grade level exists
            $gradeExists = ClassModel::where('grade_level', $request->grade_level)
                ->where('is_delete', 0)
                ->where('status', 0)
                ->exists();
            if(!$gradeExists) {
                return redirect()->back()->with('error', __('messages.grade_level_not_found'));
            }

            // Validate schedule data
            if(empty($request->schedule)) {
                return redirect()->back()->with('error', __('messages.schedule_data_required'));
            }

            foreach($request->schedule as $schedule) {
                if(empty($schedule['exam_date']) || empty($schedule['start_time']) || 
                   empty($schedule['end_time']) || empty($schedule['room_number']) || 
                   empty($schedule['full_marks']) || empty($schedule['passing_mark'])) {
                    return redirect()->back()->with('error', __('messages.all_schedule_fields_required'));
                }

                // Validate that end time is after start time
                if(strtotime($schedule['end_time']) <= strtotime($schedule['start_time'])) {
                    return redirect()->back()->with('error', __('messages.end_time_must_be_after_start_time'));
                }

                // Validate marks
                if(!is_numeric($schedule['full_marks']) || !is_numeric($schedule['passing_mark'])) {
                    return redirect()->back()->with('error', __('messages.marks_must_be_numeric'));
                }

                if($schedule['passing_mark'] > $schedule['full_marks']) {
                    return redirect()->back()->with('error', __('messages.passing_marks_cannot_exceed_full_marks'));
                }
            }

            // Delete existing schedules for this exam and grade level
            ExamScheduleModel::whereIn('class_id', function($query) use ($request) {
                $query->select('id')
                    ->from('class')
                    ->where('grade_level', $request->grade_level)
                    ->where('is_delete', 0)
                    ->where('status', 0);
            })->where('exam_id', $request->exam_id)->delete();
            
            // Get all classes for this grade level
            $classes = ClassModel::where('grade_level', $request->grade_level)
                               ->where('is_delete', 0)
                               ->where('status', 0)
                               ->get();

            if($classes->isEmpty()) {
                return redirect()->back()->with('error', __('messages.no_classes_found_for_grade'));
            }

            foreach($request->schedule as $key => $value) {
                foreach($classes as $class) {
                    $exam_schedule = new ExamScheduleModel;
                    $exam_schedule->exam_id = $request->exam_id;
                    $exam_schedule->class_id = $class->id;
                    $exam_schedule->subject_id = $value['subject_id'];
                    $exam_schedule->exam_date = $value['exam_date'];
                    $exam_schedule->start_time = $value['start_time'];
                    $exam_schedule->end_time = $value['end_time'];
                    $exam_schedule->room_number = $value['room_number'];
                    $exam_schedule->full_marks = $value['full_marks'];
                    $exam_schedule->passing_mark = $value['passing_mark'];
                    $exam_schedule->created_by = auth()->user()->id;
                    $exam_schedule->save();
                }
            }

            return redirect()->back()->with('success', __('messages.exam_schedule_successfully_saved'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.something_went_wrong'));
        }
    }

    public function marks_register(Request $request)
    {
        try {
            $data['getExam'] = ExamModel::getExam();
            $data['getGradeLevels'] = ClassModel::select('grade_level')
                ->where('is_delete', 0)
                ->where('status', 0)
                ->whereNotNull('grade_level')
                ->groupBy('grade_level')
                ->orderBy('grade_level', 'asc')
                ->get();

            if(!empty($request->get('exam_id')) && !empty($request->get('grade_level')))
            {
                // Get all subjects for this grade level
                $data['getSubject'] = ExamScheduleModel::select('exam_schedule.*', 'subject.name as subject_name', 'subject.type as subject_type')
                    ->join('subject', 'exam_schedule.subject_id', '=', 'subject.id')
                    ->join('class', 'exam_schedule.class_id', '=', 'class.id')
                    ->where('exam_schedule.exam_id', '=', $request->get('exam_id'))
                    ->where('class.grade_level', '=', $request->get('grade_level'))
                    ->groupBy('subject.id')
                    ->get();

                // Get all students in this grade level
                $data['getStudent'] = User::select('users.*')
                    ->join('class', 'users.class_id', '=', 'class.id')
                    ->where('users.user_type', '=', 3)
                    ->where('users.is_delete', '=', 0)
                    ->where('class.grade_level', '=', $request->get('grade_level'))
                    ->orderBy('users.name', 'ASC')
                    ->get();
            }

            $data['header_title'] = "Marks Register";
            return view('admin.examinations.marks_register', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.something_went_wrong'));
        }
    }

    public function submit_marks_register(Request $request)
    {
        try {
            if(!empty($request->mark))
            {
                foreach($request->mark as $mark)
                {
                    // Get student's class_id
                    $student = User::find($request->student_id);
                    if(!$student) {
                        continue;
                    }

                    $getAlreadyFirst = MarksRegisterModel::getAlreadyFirst($request->student_id, $request->exam_id, $request->grade_level, $mark['subject_id']);
                    
                    if(!empty($getAlreadyFirst))
                    {
                        $save = $getAlreadyFirst;
                    }
                    else
                    {
                        $save = new MarksRegisterModel;
                    }
                    
                    $save->student_id = $request->student_id;
                    $save->exam_id = $request->exam_id;
                    $save->class_id = $student->class_id;
                    $save->subject_id = $mark['subject_id'];
                    $save->class_work = !empty($mark['class_work']) ? $mark['class_work'] : 0;
                    $save->home_work = !empty($mark['home_work']) ? $mark['home_work'] : 0;
                    $save->test_work = !empty($mark['test_work']) ? $mark['test_work'] : 0;
                    $save->exam = !empty($mark['exam']) ? $mark['exam'] : 0;
                    $save->full_marks = !empty($mark['full_marks']) ? $mark['full_marks'] : 0;
                    $save->passing_mark = !empty($mark['passing_mark']) ? $mark['passing_mark'] : 0;
                    $save->created_by = auth()->user()->id;
                    $save->save();
                }

                $json['message'] = __('messages.marks_register_successfully_saved');
            }
            else
            {
                $json['message'] = __('messages.please_enter_marks');
            }
        } catch (\Exception $e) {
            $json['message'] = __('messages.something_went_wrong');
        }
        echo json_encode($json);
    }

    public function single_submit_marks_register(Request $request)
    {
        try {
            // Get student's class_id
            $student = User::find($request->student_id);
            if(!$student) {
                throw new \Exception(__('messages.student_not_found'));
            }

            $getAlreadyFirst = MarksRegisterModel::getAlreadyFirst($request->student_id, $request->exam_id, $request->grade_level, $request->subject_id);
            
            if(!empty($getAlreadyFirst))
            {
                $save = $getAlreadyFirst;
            }
            else
            {
                $save = new MarksRegisterModel;
            }
            
            $save->student_id = $request->student_id;
            $save->exam_id = $request->exam_id;
            $save->class_id = $student->class_id;
            $save->subject_id = $request->subject_id;
            $save->class_work = !empty($request->class_work) ? $request->class_work : 0;
            $save->home_work = !empty($request->home_work) ? $request->home_work : 0;
            $save->test_work = !empty($request->test_work) ? $request->test_work : 0;
            $save->exam = !empty($request->exam) ? $request->exam : 0;
            $save->created_by = auth()->user()->id;
            $save->save();
            
            $json['message'] = __('messages.marks_register_successfully_saved');
        } catch (\Exception $e) {
            $json['message'] = $e->getMessage();
        }
        echo json_encode($json);
    }

    public function marks_register_teacher(Request $request)
    {
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        $data['getExam'] = ExamScheduleModel::getExamTeacher(Auth::user()->id);
        
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id')))
        {
            $data['getSubject'] = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));

            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }
        
        $data['header_title'] = "Marks Register";
        return view('teacher.marks_register',$data);   
    }

    public function myExamTimetable(Request $request)
    {
        $class_id = Auth::user()->class_id;
        $getExam = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id, $class_id);
            $resultS = array();
            foreach($getExamTimetable as $valueS)
            {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_marks'] = $valueS->full_marks;
                $dataS['passing_mark'] = $valueS->passing_mark;
                $resultS[] = $dataS;
            }

            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }

        $data['getRecord'] = $result;

        $data['header_title'] = "My Exam Timetable";
        return view('student.my_exam_timetable',$data);   
    }

    public function myExamResult()
    {
        $result = array();
        $getExam = MarksRegisterModel::getExam(Auth::user()->id);
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $dataE['exam_id'] = $value->exam_id;
            $getExamSubject = MarksRegisterModel::getExamSubject($value->exam_id, Auth::user()->id);

            $dataSubject = array();
            foreach($getExamSubject as $exam)
            {
                $total_score = $exam['class_work'] +  $exam['test_work'] + $exam['home_work'] + $exam['exam'];
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['test_work'] = $exam['test_work'];
                $dataS['home_work'] = $exam['home_work'];
                $dataS['exam'] = $exam['exam'];
                $dataS['total_score'] = $total_score;
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['passing_mark'] = $exam['passing_mark'];
                $dataSubject[] = $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;
        }

        $data['getRecord'] = $result;
        $data['header_title'] = "My Exam Result";
        return view('student.my_exam_result',$data);  
    }

    public function myExamResultPrint(Request $request)
    {   
        $exam_id = $request->exam_id;
        $student_id = $request->student_id;

        $data['getExam'] = ExamModel::getSingle($exam_id);
        $data['getStudent'] = User::getSingle($student_id);

        $data['getClass'] = MarksRegisterModel::getClass($exam_id, $student_id);

        $data['getSetting'] = SettingModel::getSingle();
        
        $getExamSubject = MarksRegisterModel::getExamSubject($exam_id, $student_id);

        $dataSubject = array();
        foreach($getExamSubject as $exam)
        {
            $total_score = $exam['class_work'] +  $exam['test_work'] + $exam['home_work'] + $exam['exam'];

            $dataS = array();
            $dataS['subject_name'] = $exam['subject_name'];
            $dataS['class_work'] = $exam['class_work'];
            $dataS['test_work'] = $exam['test_work'];
            $dataS['home_work'] = $exam['home_work'];
            $dataS['exam'] = $exam['exam'];
            $dataS['total_score'] = $total_score;
            $dataS['full_marks'] = $exam['full_marks'];
            $dataS['passing_mark'] = $exam['passing_mark'];
            $dataSubject[] = $dataS;
        }

        $data['getExamMark'] = $dataSubject;

        return view('exam_result_print', $data); 
    }

    // teacher side work

    public function MyExamTimetableTeacher()
    {
        $result = array();
        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        foreach($getClass as $class)
        {
            $dataC = array();
            $dataC['class_name'] =  $class->class_name;

            $getExam = ExamScheduleModel::getExam($class->class_id);
            $examArray = array();
            foreach($getExam as $exam)
            {
                $dataE = array();
                $dataE['exam_name'] = $exam->exam_name;

                $getExamTimetable = ExamScheduleModel::getExamTimetable($exam->exam_id, $class->class_id);
                $subjectArray = array();
                foreach($getExamTimetable as $valueS)
                {
                    $dataS = array();
                    $dataS['subject_name'] = $valueS->subject_name;
                    $dataS['exam_date'] = $valueS->exam_date;
                    $dataS['start_time'] = $valueS->start_time;
                    $dataS['end_time'] = $valueS->end_time;
                    $dataS['room_number'] = $valueS->room_number;
                    $dataS['full_marks'] = $valueS->full_marks;
                    $dataS['passing_mark'] = $valueS->passing_mark;
                    $subjectArray[] = $dataS;
                }

                $dataE['subject'] = $subjectArray;
                $examArray[] = $dataE;
            }
            $dataC['exam'] = $examArray;

            $result[] = $dataC;
        }

        $data['getRecord'] = $result;

        $data['header_title'] = "My Exam Timetable";
        return view('teacher.my_exam_timetable',$data);   
    }

    // parent side

    public function ParentMyExamTimetable($student_id)
    {
        $getStudent = User::getSingle($student_id);

        $class_id = $getStudent->class_id;
        $getExam = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id, $class_id);
            $resultS = array();
            foreach($getExamTimetable as $valueS)
            {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_marks'] = $valueS->full_marks;
                $dataS['passing_mark'] = $valueS->passing_mark;
                $resultS[] = $dataS;
            }

            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }

        $data['getRecord'] = $result;
        $data['getStudent'] = $getStudent;
        $data['header_title'] = "Exam Timetable";
        return view('parent.my_exam_timetable',$data); 
    }

    public function ParentMyExamResult($student_id)
    {
        $data['getStudent'] = User::getSingle($student_id);
        $result = array();
        $getExam = MarksRegisterModel::getExam($student_id);
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['exam_id'] = $value->exam_id;
            $dataE['exam_name'] = $value->exam_name;
            $getExamSubject = MarksRegisterModel::getExamSubject($value->exam_id, $student_id);

            $dataSubject = array();
            foreach($getExamSubject as $exam)
            {
                $total_score = $exam['class_work'] +  $exam['test_work'] + $exam['home_work'] + $exam['exam'];
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['test_work'] = $exam['test_work'];
                $dataS['home_work'] = $exam['home_work'];
                $dataS['exam'] = $exam['exam'];
                $dataS['total_score'] = $total_score;
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['passing_mark'] = $exam['passing_mark'];
                $dataSubject[] = $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;
        }

        $data['getRecord'] = $result;
        $data['header_title'] = "My Exam Result";
        return view('parent.my_exam_result',$data);  
    }

    public function marks_grade()
    {
        $data['getRecord'] = MarksGradeModel::getRecord();
        $data['header_title'] = "Marks Grade";
        return view('admin.examinations.marks_grade.list',$data);   
    }

    public function marks_grade_add()
    {
        $data['header_title'] = "Add New Marks Grade";
        return view('admin.examinations.marks_grade.add',$data);   
    }

    public function marks_grade_insert(Request $request)
    {
        $mark = new MarksGradeModel;
        $mark->name = trim($request->name);
        $mark->percent_from = trim($request->percent_from);
        $mark->percent_to = trim($request->percent_to);
        $mark->created_by = Auth::user()->id;
        $mark->save();

        return redirect('admin/examinations/marks_grade')->with('success', __('messages.marks_grade_successfully_saved'));
    }

    public function marks_grade_edit($id)
    {
        $data['getRecord'] = MarksGradeModel::getSingle($id);
        $data['header_title'] = "Edit Marks Grade";
        return view('admin.examinations.marks_grade.edit',$data);   
    }

    public function marks_grade_update($id, Request $request)
    {
        $mark = MarksGradeModel::getSingle($id);
        $mark->name = trim($request->name);
        $mark->percent_from = trim($request->percent_from);
        $mark->percent_to = trim($request->percent_to);
        $mark->save();

        return redirect('admin/examinations/marks_grade')->with('success', __('messages.marks_grade_successfully_updated'));
    }

    public function marks_grade_delete($id)
    {
        $mark = MarksGradeModel::getSingle($id);
        $mark->delete();

        return redirect('admin/examinations/marks_grade')->with('success', __('messages.marks_grade_successfully_deleted'));   
    }
}
