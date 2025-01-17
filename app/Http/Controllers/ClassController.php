<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\SubjectModel;

class ClassController extends Controller
{
    public function list()
    {
        $data['getRecord'] = ClassModel::getRecord();
        
        // Get assigned subjects for each class
        foreach ($data['getRecord'] as $class) {
            $class->subjects = ClassSubjectModel::getAssignedSubjects($class->id);
        }

        $data['header_title'] = "Class List";
        return view('admin.class.list', $data);
    }

    public function add()
    {
        $data['header_title'] = "Add New Class";
        return view('admin.class.add', $data);
    }

    public function insert(Request $request)
    {
        $save = new ClassModel;
        $save->name = $request->name;
        $save->grade_level = $request->grade_level;
        $save->amount = $request->amount;
        $save->status = $request->status;
        $save->created_by = Auth::user()->id;
        $save->save();

        // Get all subjects with the same grade level
        $subjects = SubjectModel::where('grade_level', $request->grade_level)
                               ->where('is_delete', 0)
                               ->where('status', 0)
                               ->get();
        
        // Assign all matching subjects to the new class
        foreach ($subjects as $subject) {
            $assign = new ClassSubjectModel;
            $assign->class_id = $save->id;
            $assign->subject_id = $subject->id;
            $assign->status = 0; // Active
            $assign->created_by = Auth::user()->id;
            $assign->save();
        }

        return redirect('admin/class/list')->with('success', "Class Successfully Created with Assigned Subjects");
    }
    public function edit($id)
    {
        $data['getRecord'] = ClassModel::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title'] = "Edit Class";
            return view('admin.class.edit', $data);    
        }
        else
        {
            abort(404);
        }        
    }

    public function update($id, Request $request)
    {
        $save = ClassModel::getSingle($id);
        $oldGradeLevel = $save->grade_level;
        
        $save->name = $request->name;
        $save->grade_level = $request->grade_level;
        $save->amount = $request->amount;
        $save->status = $request->status;
        $save->save();

        // If grade level has changed
        if ($oldGradeLevel !== $request->grade_level) {
            // Remove old subjects
            ClassSubjectModel::where('class_id', $id)
                           ->update(['is_delete' => 1]);

            // Get all subjects for the new grade level
            $subjects = SubjectModel::where('grade_level', $request->grade_level)
                                   ->where('is_delete', 0)
                                   ->where('status', 0)
                                   ->get();
            
            // Assign new subjects
            foreach ($subjects as $subject) {
                $assign = new ClassSubjectModel;
                $assign->class_id = $id;
                $assign->subject_id = $subject->id;
                $assign->status = 0; // Active
                $assign->created_by = Auth::user()->id;
                $assign->save();
            }
        }

        return redirect('admin/class/list')->with('success', "Class Successfully Updated with New Subjects");
    }
    public function delete($id)
    {
        $save = ClassModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', "Class Successfully Deleted");
    }
}
