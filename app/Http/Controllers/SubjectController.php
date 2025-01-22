<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectModel;
use App\Models\ClassSubjectModel;
use App\Models\User;
use App\Models\ClassModel;

use Auth;
use Log;
use DB;

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

        // Handle curriculum file upload
        if ($request->hasFile('curriculum_file')) {
            // Ensure upload directory exists
            $uploadPath = public_path('uploads/curriculum');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            try {
                $file = $request->file('curriculum_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($uploadPath, $fileName);
                $save->curriculum_file = $fileName;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Error uploading file: ' . $e->getMessage());
            }
        }

        try {
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

            return redirect('admin/subject/list')->with('success', 'Subject Successfully Added');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving subject: ' . $e->getMessage());
        }
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
        $subject = SubjectModel::getSingle($id);
        $oldGradeLevel = $subject->grade_level;
        
        $subject->name = $request->name;
        $subject->grade_level = $request->grade_level;
        $subject->type = $request->type;
        $subject->status = $request->status;

        // Handle curriculum file update
        if ($request->hasFile('curriculum_file')) {
            Log::info('File upload detected in update');
            
            // Ensure upload directory exists
            $uploadPath = public_path('uploads/curriculum');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
                Log::info('Created directory: ' . $uploadPath);
            }

            // Delete old file if exists
            if ($subject->curriculum_file) {
                $oldFilePath = public_path('uploads/curriculum/' . $subject->curriculum_file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                    Log::info('Deleted old file: ' . $oldFilePath);
                }
            }

            try {
                // Upload new file
                $file = $request->file('curriculum_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                Log::info('Attempting to move file to: ' . $uploadPath . '/' . $fileName);
                
                $file->move($uploadPath, $fileName);
                $subject->curriculum_file = $fileName;
                Log::info('File uploaded successfully. Filename: ' . $fileName);
            } catch (\Exception $e) {
                Log::error('File upload error: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Error uploading file: ' . $e->getMessage());
            }
        } else {
            Log::info('No file uploaded with request');
        }

        try {
            $subject->save();
            Log::info('Subject saved with curriculum_file: ' . $subject->curriculum_file);

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

            return redirect('admin/subject/list')
                ->with('success', "Subject Successfully Updated");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving subject: ' . $e->getMessage());
        }
    }

    public function downloadCurriculum($id)
{
    $subject = SubjectModel::findOrFail($id);
    if ($subject->curriculum_file) {
        $path = public_path('uploads/curriculum/' . $subject->curriculum_file);
        if (file_exists($path)) {
            return response()->download($path);
        }
    }
    return back()->with('error', __('messages.file_not_found'));
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
        $data['getRecord'] = DB::table('class_subject')
            ->select(
                'subject.id as subject_id',
                'subject.name as subject_name',
                'subject.type as subject_type',
                'subject.curriculum_file'
            )
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->where('class_subject.class_id', '=', Auth::user()->class_id)
            ->where('class_subject.status', '=', 0)
            ->where('class_subject.is_delete', '=', 0)
            ->orderBy('subject.name', 'ASC')
            ->get();

        $data['header_title'] = "My Subject";
        return view('student.my_subject', $data);
    }


    // parent side

    public function ParentStudentSubject($student_id)
    {
        $user = User::getSingle($student_id);
        $data['getUser'] = $user;
        $data['getRecord'] = DB::table('class_subject')
            ->select(
                'subject.id as subject_id',
                'subject.name as subject_name',
                'subject.type as subject_type',
                'subject.curriculum_file'
            )
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->where('class_subject.class_id', '=', $user->class_id)
            ->where('class_subject.status', '=', 0)
            ->where('class_subject.is_delete', '=', 0)
            ->orderBy('subject.name', 'ASC')
            ->get();

        $data['header_title'] = "Student Subject";
        return view('parent.my_student_subject', $data);
    }
}
