<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\AssignClassTeacherModel;
use Auth;


class AssignClassTeacherController extends Controller
{
    public function list(Request $request)
    {
        
        $data['getRecord'] = AssignClassTeacherModel::getRecord();

        $data['header_title'] = "Assign Class Teacher";
        return view('admin.assign_class_teacher.list', $data);
    }

    public function add(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();
        
        $data['header_title'] = "Add Assign Class Teacher";
        return view('admin.assign_class_teacher.add', $data);
    }

    public function insert(Request $request)
    {

        if(!empty($request->teacher_id))
        {
            foreach ($request->teacher_id as $teacher_id) 
            {
                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                if(!empty($getAlreadyFirst))
                {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }
                else
                {
                    $save = new AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();    
                }
            }

            return redirect('admin/assign_class_teacher/list')->with('success', __('messages.assign_class_teacher_successfully'));
        }
        else
        {
            return redirect()->back()->with('error', __('messages.due_to_some_error_pls_try_again'));
        }
        
    }


    public function edit($id)
    {
        $getRecord = AssignClassTeacherModel::getSingle($id);
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getAssignTeacherID'] = AssignClassTeacherModel::getAssignTeacherID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            // Get the class details to get the grade level
            $data['classDetails'] = ClassModel::find($getRecord->class_id);
            $data['header_title'] = "Edit Assign Class Teacher";
            return view('admin.assign_class_teacher.edit', $data);    
        }
        else
        {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        AssignClassTeacherModel::deleteTeacher($request->class_id);


        if(!empty($request->teacher_id))
        {
            foreach ($request->teacher_id as $teacher_id) 
            {
                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                if(!empty($getAlreadyFirst))
                {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }
                else
                {
                    $save = new AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();    
                }
            }            
        }

        return redirect('admin/assign_class_teacher/list')->with('success', __('messages.assign_class_teacher_successfully'));
    }

    public function edit_single($id)
    {
        $getRecord = AssignClassTeacherModel::getSingle($id);
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = "Edit Assign Class Teacher";
            return view('admin.assign_class_teacher.edit_single', $data);    
        }
        else
        {
            abort(404);
        }
    }



    public function update_single($id, Request $request)
    {

            $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $request->teacher_id);
            if(!empty($getAlreadyFirst))
            {
                $getAlreadyFirst->status = $request->status;
                $getAlreadyFirst->save();

                return redirect('admin/assign_class_teacher/list')->with('success', __('messages.status_successfully_updated'));

            }
            else
            {
                $save = AssignClassTeacherModel::getSingle($id);
                $save->class_id = $request->class_id;
                $save->teacher_id = $request->teacher_id;
                $save->status = $request->status;
                $save->save();    

                return redirect('admin/assign_class_teacher/list')->with('success', __('messages.assign_class_teacher_successfully_updated'));
            }                    
    }


    public function delete($id)
    {
        $save = AssignClassTeacherModel::getSingle($id);
        $save->delete();

        return redirect()->back()->with('success', __('messages.assign_class_teacher_successfully_deleted'));
    }


    // teacher side work

    public function MyClassSubject()
    {
        $data['getRecord'] = AssignClassTeacherModel::getMyClassSubject(Auth::user()->id);
        $data['header_title'] = "My Class & Subject";
        return view('teacher.my_class_subject', $data); 
    }

    public function get_class_by_grade_level(Request $request)
    {
        $getClass = ClassModel::select('id', 'name')
                    ->where('grade_level', '=', $request->grade_level)
                    ->where('is_delete', '=', 0)
                    ->where('status', '=', 0)
                    ->orderBy('name', 'asc')
                    ->get();

        $html = '<option value="">'. __('messages.select_class') .'</option>';
        foreach($getClass as $class) {
            $html .= '<option value="'.$class->id.'">'.$class->name.'</option>';
        }

        return response()->json(['html' => $html]);
    }
}
