<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use App\Exports\ExportStudent;
use App\Models\NoticeBoardModel;
use App\Models\SubjectModel;
use Hash;
use Auth;
use Str;
use Excel;

class StudentController extends Controller
{
    public function export_excel(Request $request)
    {
        return Excel::download(new ExportStudent, 'Student_'.date('d-m-Y').'.xls');        
    }

    public function list()
    {
        $data['getRecord'] = User::getStudent();
        $data['header_title'] = "Student List";
        return view('admin.student.list',$data);
    }

    public function add()
    {
        $data['getClass'] = ClassModel::select('class.*')
            ->where('is_delete', 0)
            ->where('status', 0)
            ->orderBy('name', 'asc')
            ->get();
            
        $data['header_title'] = "Add New Student";
        return view('admin.student.add', $data);
    }

    public function insert(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users',
            'grade_level' => 'required',
            'weight' => 'max:10',
            'blood_group' => 'max:10',
            'mobile_number' => 'max:15|min:8',            
            'height' => 'max:10'            
        ]);

        $student = new User;
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->grade_level = $request->grade_level;
        $student->gender = $request->gender;
 
        if(!empty($request->date_of_birth))
        {
            $student->date_of_birth = trim($request->date_of_birth);    
        }

        if(!empty($request->file('profile_pic')))
        {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');   
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            
            $student->profile_pic = $filename;            
        }

        $student->mobile_number = trim($request->mobile_number);

        if(!empty($request->admission_date))
        {
            $student->admission_date = trim($request->admission_date);    
        }
        
        $student->blood_group = trim($request->blood_group);
        $student->height = trim($request->height);
        $student->weight = trim($request->weight);
        $student->status = trim($request->status);
        $student->email = trim($request->email);
        $student->password = Hash::make($request->password);
        $student->user_type = 3;
        $student->save();

        return redirect('admin/student/list')->with('success', "Student Successfully Created");
        
        
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = "Edit Student";
            return view('admin.student.edit',$data);    
        }
        else
        {
            abort(404);
        }
        
    }

    public function update($id, Request $request)
    {
         request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'weight' => 'max:10',
            'blood_group' => 'max:10',
            'mobile_number' => 'max:15|min:8',            
            'height' => 'max:10'            
        ]);


        $student = User::getSingle($id);;
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->class_id = trim($request->class_id);
        $student->gender = trim($request->gender);

        if(!empty($request->date_of_birth))
        {
            $student->date_of_birth = trim($request->date_of_birth);    
        }

        if(!empty($request->file('profile_pic')))
        {
            if(!empty($student->getProfile()))
            {
                unlink('upload/profile/'.$student->profile_pic);
            }

            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');   
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $student->profile_pic = $filename;            
        }

        $student->mobile_number = trim($request->mobile_number);

        if(!empty($request->admission_date))
        {
            $student->admission_date = trim($request->admission_date);    
        }
        
        $student->blood_group = trim($request->blood_group);
        $student->height = trim($request->height);
        $student->weight = trim($request->weight);
        $student->status = trim($request->status);
        $student->email = trim($request->email);

        if(!empty($request->password))
        {
            $student->password = Hash::make($request->password);    
        }
        
        $student->save();

        return redirect('admin/student/list')->with('success', "Student Successfully Updated");
    }

    public function delete($id)
    {
         $getRecord = User::getSingle($id);
        if(!empty($getRecord))
        {
            $getRecord->is_delete = 1;
            $getRecord->save();

            return redirect()->back()->with('success', "Student Successfully Deleted");
        }
        else
        {
            abort(404);
        }
    }


    // teacher side work

    public function MyStudent()
    {
        $data['getRecord'] = User::getTeacherStudent(Auth::user()->id);
        $data['header_title'] = "My Student List";
        return view('teacher.my_student',$data);
    }

    public function downloadCurriculum($subject_id)
    {
        try {
            $subject = SubjectModel::findOrFail($subject_id);
            
            if ($subject->curriculum_file) {
                $path = public_path('uploads/curriculum/' . $subject->curriculum_file);
                if (file_exists($path)) {
                    return response()->download($path);
                }
            }
            
            return redirect()->back()->with('error', __('messages.file_not_found'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error_downloading_file'));
        }
    }

    public function mySubject()
    {
        $student = Auth::user();
        \Log::info('Student grade level: ' . $student->grade_level);
        
        $query = \DB::table('class_subject')
            ->select('subject.id as subject_id', 'subject.name as subject_name', 
                    'subject.type as subject_type', 'subject.curriculum_file')
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->join('class', 'class.id', '=', 'class_subject.class_id')
            ->where('class.grade_level', '=', $student->grade_level)
            ->where('class_subject.status', '=', 0)
            ->where('class_subject.is_delete', '=', 0)
            ->orderBy('subject.name', 'ASC');

        \Log::info('SQL Query: ' . $query->toSql());
        \Log::info('Query Bindings: ', $query->getBindings());
        
        $getRecord = $query->get();
        \Log::info('Records found: ' . count($getRecord));
        \Log::info('Records: ', $getRecord->toArray());

        $data['getRecord'] = $getRecord;
        $data['header_title'] = "My Subject";
        return view('student.my_subject', $data);
    }

    public function MyNoticeBoardStudent()
    {
        $data['getRecord'] = NoticeBoardModel::select(
                                'notice_board.id',
                                'notice_board.title',
                                'notice_board.message',
                                'notice_board.notice_date',
                                'notice_board.publish_date',
                                'users.name as created_by_name',
                                'users.user_type'
                            )
                            ->join('users', 'users.id', '=', 'notice_board.created_by')
                            ->whereDate('notice_board.publish_date', '<=', date('Y-m-d'))
                            ->orderBy('notice_board.id', 'desc')
                            ->paginate(20);
        $data['header_title'] = __('messages.noticeboard');
        return view('student.my_notice_board', $data);
    }
}
