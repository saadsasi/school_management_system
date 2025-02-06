<?php

namespace App\Http\Controllers;

use App\Models\SubjectModel;
use Illuminate\Http\Request;
use App\Models\TeacherSubject;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use App\Models\ClassModel;
use Auth;
use App\Models\TeacherEvaluation;

class TeacherSubjectController extends Controller
{
    public function list(Request $request)
    {
        $query = User::select('users.*')
            ->selectRaw('COUNT(DISTINCT teacher_subjects.subject_id) as subjects_count')
            ->leftJoin('teacher_subjects', 'users.id', '=', 'teacher_subjects.teacher_id')
            ->where('users.user_type', '=', 2)
            ->where('users.is_delete', '=', 0);

        // Filter by first name
        if (!empty($request->get('name'))) {
            $query->where('users.name', 'like', '%' . $request->get('name') . '%');
        }

        // Filter by last name
        if (!empty($request->get('last_name'))) {
            $query->where('users.last_name', 'like', '%' . $request->get('last_name') . '%');
        }

        // Filter by subject
        if (!empty($request->get('subject_id'))) {
            $query->whereExists(function ($query) use ($request) {
                $query->select(DB::raw(1))
                    ->from('teacher_subjects')
                    ->whereRaw('teacher_subjects.teacher_id = users.id')
                    ->where('teacher_subjects.subject_id', $request->get('subject_id'));
            });
        }

        $data['users'] = $query->groupBy('users.id')
            ->orderBy('users.id', 'desc')
            ->paginate(20);

        $data['subjects'] = SubjectModel::getSubject();
        $data['header_title'] = "Teacher Subjects";
        return view('admin.teacher_subject.list', $data);
    }

    public function create()
    {
        $data['getTeacher'] = User::getTeacher();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = "Add Teacher Subject";
        return view('admin.teacher_subject.add', $data);
    }

    public function store(Request $request)
    {
        $subject_ids = $request->subject_ids;
        $class = ClassModel::find($request->class_id);
        
        if (!empty($subject_ids)) {
            foreach ($subject_ids as $subject_id) {
                TeacherSubject::create([
                    'teacher_id' => $request->teacher_id,
                    'subject_id' => $subject_id,
                    'class_id' => $request->class_id,
                    'grade_level' => $class->grade_level // استخدام grade من الصف
                ]);
            }
        }
        
        return redirect('admin/teacher_subject/view/'.$request->teacher_id)->with('success', 'Subjects Successfully Added');
    }

    public function add($teacher_id)
    {
        $data['getTeacher'] = User::find($teacher_id);
        $data['grades'] = ClassModel::select('grade_level')
                            ->distinct()
                            ->where('is_delete', 0)
                            ->where('status', 0)
                            ->orderBy('grade_level')
                            ->get();

        // Get existing teacher subjects
        $data['existingSubjects'] = TeacherSubject::where('teacher_id', $teacher_id)
                                    ->pluck('subject_id')
                                    ->toArray();

        return view('admin.teacher_subject.add', $data);
    }

    public function getClassesAndSubjects(Request $request)
    {
        $grade_level = $request->grade_level;
        $teacher_id = $request->teacher_id;
        
        // Get classes for this grade level
        $classes = ClassModel::where('grade_level', $grade_level)
                        ->where('is_delete', 0)
                        ->where('status', 0)
                        ->orderBy('name')
                        ->get();

        // Get subjects for this grade level only
        $subjects = SubjectModel::where('grade_level', $grade_level)
                        ->where('is_delete', 0)
                        ->where('status', 0)
                        ->orderBy('name')
                        ->get();

        // Get all existing subjects for this teacher (to maintain checked status)
        $existingSubjects = TeacherSubject::where('teacher_id', $teacher_id)
                            ->pluck('subject_id')
                            ->toArray();
        
        return response()->json([
            'classes' => $classes,
            'subjects' => $subjects,
            'existingSubjects' => $existingSubjects
        ]);
    }
    
    public function editSubjects($teacher_id)
    {
        $data['getTeacher'] = User::find($teacher_id);
        $data['grades'] = ClassModel::select('grade_level')
                    ->distinct()
                    ->orderBy('grade_level')
                    ->get();
        $data['getSubjects'] = SubjectModel::orderBy('name')->get();
        $data['getClass'] = ClassModel::orderBy('name')->get();
        $data['assignedSubjects'] = TeacherSubject::where('teacher_id', $teacher_id)
            ->with(['subject', 'class'])
            ->get();
    
        return view('admin.teacher_subject.edit', $data);
    }

    public function view($teacher_id)
    {
        $teacher = User::find($teacher_id);
        $subjects = TeacherSubject::where('teacher_id', $teacher_id)
            ->with(['subject', 'class'])
            ->get();
        
        return view('admin.teacher_subject.view', compact('teacher', 'subjects'));
    }
    
    public function showSubjects($teacher_id)
    {
        $teacher = User::find($teacher_id);
        $subjects = TeacherSubject::where('teacher_id', $teacher_id)
            ->with(['subject', 'class'])
            ->get();
        
        return view('admin.teacher_subject.teacher_subjects', compact('teacher', 'subjects'));
    }

    public function evaluate(Request $request, $id)
    {
        $request->validate([
            'evaluation_date' => 'required|date',
            'notes' => 'required|string'
        ]);

        TeacherEvaluation::create([
            'teacher_subject_id' => $id,
            'evaluation_date' => $request->evaluation_date,
            'notes' => $request->notes,
            'created_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'تم حفظ التقييم بنجاح');
    }

    public function viewEvaluations($id)
    {
        $subject = TeacherSubject::with(['subject', 'teacher'])->findOrFail($id);
        $evaluations = TeacherEvaluation::where('teacher_subject_id', $id)
            ->with(['creator'])
            ->orderBy('evaluation_date', 'desc')
            ->get();
        
        return view('admin.teacher_subject.evaluations', compact('evaluations', 'subject'));
    }

    public function edit($id)
    {
        $data['getRecord'] = TeacherSubject::find($id);
        $data['getTeacher'] = User::getTeacher();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = "Edit Teacher Subject";
        return view('admin.teacher_subject.edit', $data);
    }

    public function update(Request $request, $teacher_id)
    {
        TeacherSubject::where('teacher_id', $teacher_id)->delete();
        
        $subject_ids = $request->subject_ids;
        $class = ClassModel::find($request->class_id);
        
        if (!empty($subject_ids)) {
            foreach ($subject_ids as $subject_id) {
                TeacherSubject::create([
                    'teacher_id' => $teacher_id,
                    'subject_id' => $subject_id,
                    'class_id' => $request->class_id,
                    'grade_level' => $class->grade_level // استخدام grade من الصف
                ]);
            }
        }
        
        return redirect('admin/teacher_subject/view/'.$teacher_id)->with('success', 'Subjects Successfully Updated');
    }
    public function delete($id)
    {
        $teacherSubject = TeacherSubject::find($id);
        $teacherSubject->delete();
        return redirect('admin/teacher_subject/list')->with('success', 'Teacher Subject Successfully Deleted');
    }

    public function deleteSubject($id)
{
    $subject = SubjectModel::find($id); // Assuming you have a Subject model

    if ($subject) {
        $subject->delete();
        return redirect()->back()->with('success', __('messages.subject_deleted')); // Adjust the message as needed
    } else {
        return redirect()->back()->with('error', __('messages.subject_not_found')); // Adjust the message as needed
    }
}
}