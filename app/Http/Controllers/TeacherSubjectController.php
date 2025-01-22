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
    public function list()
    {
        $data['getRecord'] = TeacherSubject::with(['teacher', 'subject', 'class'])->get();
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

    public function index(Request $request)
    {
        $data['subjects'] = SubjectModel::all();
        
        $query = DB::table('users')
            ->leftJoin('teacher_subjects', 'users.id', '=', 'teacher_subjects.teacher_id')
            ->select('users.id', 'users.name', DB::raw('COUNT(teacher_subjects.id) as subjects_count'))
            ->where('users.user_type', '=', 2)
            ->groupBy('users.id', 'users.name');
    
        // البحث باسم المعلم
        if (!empty($request->name)) {
            $query->where('users.name', 'like', '%' . $request->name . '%');
        }
    
        // البحث بالمادة
        if (!empty($request->subject_id)) {
            $query->join('teacher_subjects as ts', function($join) use ($request) {
                $join->on('users.id', '=', 'ts.teacher_id')
                     ->where('ts.subject_id', '=', $request->subject_id);
            });
        }
    
        $data['teachers'] = $query->orderBy('users.id', 'desc')
            ->paginate(15);
    
        return view('admin.teacher_subject.list', $data);
    }
  
    public function add($teacher_id)
{
    $data['getTeacher'] = User::find($teacher_id);
    $data['grades'] = ClassModel::select('grade_level')
                    ->distinct()
                    ->orderBy('grade_level')
                    ->get();
    $data['getSubjects'] = SubjectModel::orderBy('name')->get();
    $data['getClass'] = ClassModel::orderBy('name')->get();
    return view('admin.teacher_subject.add', $data);
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

// إضافة method جديدة للحصول على الفصول والمواد حسب grade_level
public function getClassesAndSubjects(Request $request)
{
    $grade_level = $request->grade_level;
    $classes = ClassModel::where('grade_level', $grade_level)
                        ->orderBy('name')
                        ->get();
    $subjects = SubjectModel::where('grade_level', $grade_level)
                        ->orderBy('name')
                        ->get();
    
    return response()->json([
        'classes' => $classes,
        'subjects' => $subjects
    ]);
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

        // Save the evaluation to your database
        TeacherEvaluation::create([
            'teacher_subject_id' => $id,
            'evaluation_date' => $request->evaluation_date,
            'notes' => $request->notes,
            'created_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'تم حفظ التقييم بنجاح');
    }

    public function viewEvaluations($id)
    {
        $evaluations = TeacherEvaluation::where('teacher_subject_id', $id)
            ->with(['creator'])
            ->orderBy('evaluation_date', 'desc')
            ->get();
        
        $subject = TeacherSubject::with(['subject', 'teacher'])->findOrFail($id);
        
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
}