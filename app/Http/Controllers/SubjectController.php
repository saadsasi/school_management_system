<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectModel;
use App\Models\ClassSubjectModel;
use App\Models\User;
use App\Models\ClassModel;

use Auth;

class SubjectController extends Controller
{
    public function list()
    {
        $data['getRecord'] = SubjectModel::getRecord();

        $data['header_title'] = "Subject List";
        return view('admin.subject.list', $data);
    }

    public function add()
    {
        $data['header_title'] = "Add Subject";
        return view('admin.subject.add', $data);
    }

    public function insert(Request $request)
    {
        $save = new SubjectModel;
        $save->name = trim($request->name);
        $save->grade_level = $request->grade_level;
        $save->type = trim($request->type);
        $save->status = trim($request->status);
        $save->created_by = Auth::user()->id;
        $save->save();

        // Get all classes with the same grade level
        $classes = ClassModel::getClassesByGradeLevel($request->grade_level);
        
        // Assign the subject to all matching classes
        foreach ($classes as $class) {
            // Check if the subject is not already assigned to this class
            $check = ClassSubjectModel::getAlreadyFirst($class->id, $save->id);
            
            if (empty($check)) {
                $assign = new ClassSubjectModel;
                $assign->class_id = $class->id;
                $assign->subject_id = $save->id;
                $assign->status = 0; // Active
                $assign->created_by = Auth::user()->id;
                $assign->save();
            }
        }

        return redirect('admin/subject/list')->with('success', "Subject Successfully Created and Assigned to Classes");
    }

    public function edit($id)
    {
        $data['getRecord'] = SubjectModel::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title'] = "Edit Subject";
            return view('admin.subject.edit', $data);    
        }
        else
        {
            abort(404);
        }       
    }

    public function update($id, Request $request)
    {
        $save = SubjectModel::getSingle($id);
        $oldGradeLevel = $save->grade_level;
        
        $save->name = trim($request->name);
        $save->grade_level = $request->grade_level;
        $save->type = trim($request->type);
        $save->status = trim($request->status);
        $save->save();

        // If grade level has changed
        if ($oldGradeLevel !== $request->grade_level) {
            // Remove subject from classes of old grade level
            $oldClasses = ClassModel::getClassesByGradeLevel($oldGradeLevel);
            foreach ($oldClasses as $class) {
                $assignment = ClassSubjectModel::getAlreadyFirst($class->id, $id);
                if ($assignment) {
                    $assignment->is_delete = 1;
                    $assignment->save();
                }
            }

            // Assign to classes of new grade level
            $newClasses = ClassModel::getClassesByGradeLevel($request->grade_level);
            foreach ($newClasses as $class) {
                $check = ClassSubjectModel::getAlreadyFirst($class->id, $id);
                
                if (empty($check)) {
                    $assign = new ClassSubjectModel;
                    $assign->class_id = $class->id;
                    $assign->subject_id = $id;
                    $assign->status = 0;
                    $assign->created_by = Auth::user()->id;
                    $assign->save();
                } elseif ($check->is_delete == 1) {
                    $check->is_delete = 0;
                    $check->save();
                }
            }
        }

        return redirect('admin/subject/list')->with('success', "Subject Successfully Updated");
    }

    public function delete($id)
    {
        $save = SubjectModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', "Subject Sucessfully Deleted");
    }


    // student side

    public function MySubject()
    {
        
        $data['getRecord'] = ClassSubjectModel::MySubject(Auth::user()->class_id);

        $data['header_title'] = "My Subject";
        return view('student.my_subject', $data);
    }


    // parent side

    public function ParentStudentSubject($student_id)
    {
        $user = User::getSingle($student_id);
        $data['getUser'] = $user;
        $data['getRecord'] = ClassSubjectModel::MySubject($user->class_id);
        $data['header_title'] = "Student Subject";
        return view('parent.my_student_subject', $data);
    }
}
