<?php

namespace App\Http\Controllers;

use App\Exports\ExportCollectFees;
use App\Exports\ExportExaminations;
use App\Models\ClassModel;
use App\Models\StudentAddFeesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportStudent;
use App\Exports\ExportTeacher;
use App\Exports\lExportCollectFees;
use App\Exports\ExaminationsExport;

class ReportController extends Controller
{
    public function index()
    {
        $data['classes'] = ClassModel::where('is_delete', 0)
            ->where('status', 0)
            ->orderBy('name', 'asc')
            ->get();

        $data['gradeLevels'] = ClassModel::where('is_delete', 0)
            ->where('status', 0)
            ->distinct()
            ->pluck('grade_level')
            ->sort()
            ->values();

        $data['totalStudents'] = User::where('user_type', 3)->count();
        $data['totalTeachers'] = User::where('user_type', 2)->count();
        $data['totalClasses'] = ClassModel::where('is_delete', 0)->count();
        $data['totalFees'] = StudentAddFeesModel::sum('paid_amount');

        return view('reports.reports', $data);
    } 

    public function studentsReport(Request $request)
    {
        $reportType = $request->report_type;
        $classId = $request->class_id;
        $data = [];
        $class = ClassModel::find($classId);

        switch ($reportType) {
            case 'attendance':
                $data = DB::table('class_subject_timetable')
                    ->join('class_subject', 'class_subject.id', '=', 'class_subject_timetable.subject_id')
                    ->join('class', 'class.id', '=', 'class_subject.class_id')
                    ->join('student_attendance', 'student_attendance.class_id', '=', 'class.id')
                    ->where('class.id', $classId)
                    ->select(
                        'student_attendance.*',
                        'class.name as class_name'
                    )
                    ->get()
                    ->groupBy('student_id');
                break;

            case 'grades':
                $data = DB::table('exam_results')
                    ->join('students', 'students.id', '=', 'exam_results.student_id')
                    ->join('class', 'class.id', '=', 'students.class_id')
                    ->where('class.id', $classId)
                    ->select(
                        'students.name as student_name',
                        'exam_results.*',
                        'class.name as class_name'
                    )
                    ->get()
                    ->groupBy('student_name');
                break;

            case 'fees':
                $data = DB::table('fees_collection')
                    ->join('students', 'students.id', '=', 'fees_collection.student_id')
                    ->join('class', 'class.id', '=', 'students.class_id')
                    ->where('class.id', $classId)
                    ->select(
                        'students.name as student_name',
                        'fees_collection.*',
                        'class.name as class_name'
                    )
                    ->get()
                    ->groupBy('student_name');
                break;
        }

        

        return view('reports.students', compact('data', 'reportType', 'class'));
    }

    public function teachersReport(Request $request)
    {
        $reportType = $request->report_type;
        $date = $request->date;
        $data = [];

        switch ($reportType) {
            case 'classes':
                $data = DB::table('assign_class_teacher')
                    ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
                    ->join('users', 'users.id', '=', 'assign_class_teacher.teacher_id')
                    ->select(
                        'users.name as teacher_name',
                        'class.name as class_name',
                        'assign_class_teacher.*'
                    )
                    ->get()
                    ->groupBy('teacher_name');
                break;

            case 'attendance':
                $query = DB::table('teacher_attendance')
                    ->join('users', 'users.id', '=', 'teacher_attendance.teacher_id');
                
                if ($date) {
                    $query->whereDate('teacher_attendance.date', $date);
                }

                $data = $query->select(
                    'users.name as teacher_name',
                    'teacher_attendance.*'
                )
                ->get()
                ->groupBy('teacher_name');
                break;

            case 'performance':
                $data = DB::table('teacher_performance')
                    ->join('users', 'users.id', '=', 'teacher_performance.teacher_id')
                    ->select(
                        'users.name as teacher_name',
                        'teacher_performance.*'
                    )
                    ->get()
                    ->groupBy('teacher_name');
                break;
        }

        return view('reports.teachers', compact('data', 'reportType', 'date'));
    }

    public function financialReport(Request $request)
    {
        $reportType = $request->report_type;
        $period = $request->period;
        $data = [];

        switch ($reportType) {
            case 'fees_collection':
                $query = DB::table('fees_collection')
                    ->join('students', 'students.id', '=', 'fees_collection.student_id')
                    ->join('class', 'class.id', '=', 'students.class_id');

                if ($period == 'monthly') {
                    $query->whereMonth('fees_collection.created_at', now()->month);
                } elseif ($period == 'quarterly') {
                    $query->whereMonth('fees_collection.created_at', '>=', now()->subMonths(3));
                } elseif ($period == 'yearly') {
                    $query->whereYear('fees_collection.created_at', now()->year);
                }

                $data = $query->select(
                    'students.name as student_name',
                    'class.name as class_name',
                    'fees_collection.*'
                )
                ->get()
                ->groupBy('class_name');
                break;

            case 'expenses':
                $query = DB::table('expenses');

                if ($period == 'monthly') {
                    $query->whereMonth('created_at', now()->month);
                } elseif ($period == 'quarterly') {
                    $query->whereMonth('created_at', '>=', now()->subMonths(3));
                } elseif ($period == 'yearly') {
                    $query->whereYear('created_at', now()->year);
                }

                $data = $query->get()->groupBy('category');
                break;

            case 'summary':
                $query = DB::table('fees_collection')
                    ->select(
                        DB::raw('SUM(paid_amount) as total_fees'),
                        DB::raw('MONTH(created_at) as month')
                    )
                    ->groupBy('month');

                if ($period == 'monthly') {
                    $query->whereMonth('created_at', now()->month);
                } elseif ($period == 'quarterly') {
                    $query->whereMonth('created_at', '>=', now()->subMonths(3));
                } elseif ($period == 'yearly') {
                    $query->whereYear('created_at', now()->year);
                }

                $data['fees'] = $query->get();

                $query = DB::table('expenses')
                    ->select(
                        DB::raw('SUM(amount) as total_expenses'),
                        DB::raw('MONTH(created_at) as month')
                    )
                    ->groupBy('month');

                if ($period == 'monthly') {
                    $query->whereMonth('created_at', now()->month);
                } elseif ($period == 'quarterly') {
                    $query->whereMonth('created_at', '>=', now()->subMonths(3));
                } elseif ($period == 'yearly') {
                    $query->whereYear('created_at', now()->year);
                }

                $data['expenses'] = $query->get();
                break;
        }

        return view('reports.financial', compact('data', 'reportType', 'period'));
    }

    public function examinationsReport(Request $request)
    {
        $reportType = $request->report_type;
        $classId = $request->class_id;
        $data = [];
        $class = ClassModel::find($classId);

        switch ($reportType) {
            case 'results':
                $data = DB::table('exam_results')
                    ->join('students', 'students.id', '=', 'exam_results.student_id')
                    ->join('class', 'class.id', '=', 'students.class_id')
                    ->where('class.id', $classId)
                    ->select(
                        'students.name as student_name',
                        'exam_results.*',
                        'class.name as class_name'
                    )
                    ->get()
                    ->groupBy('exam_name');
                break;

            case 'analysis':
                $data = DB::table('exam_results')
                    ->join('students', 'students.id', '=', 'exam_results.student_id')
                    ->join('class', 'class.id', '=', 'students.class_id')
                    ->where('class.id', $classId)
                    ->select(
                        DB::raw('AVG(marks) as average_marks'),
                        DB::raw('MAX(marks) as highest_marks'),
                        DB::raw('MIN(marks) as lowest_marks'),
                        'exam_name',
                        'class.name as class_name'
                    )
                    ->groupBy('exam_name', 'class_name')
                    ->get();
                break;

            case 'comparison':
                $data = DB::table('exam_results')
                    ->join('students', 'students.id', '=', 'exam_results.student_id')
                    ->join('class', 'class.id', '=', 'students.class_id')
                    ->where('class.id', $classId)
                    ->select(
                        'students.name as student_name',
                        'exam_results.*',
                        'class.name as class_name'
                    )
                    ->orderBy('marks', 'desc')
                    ->get()
                    ->groupBy('exam_name');
                break;
        }

        return view('reports.examinations', compact('data', 'reportType', 'class'));
    }

    public function studentsWithGuardians()
    {
        $data = User::where('user_type', '=', 3) // Students
            ->join('users as guardians', 'users.guardian_id', '=', 'guardians.id')
            ->select('users.name', 'users.email', 'users.mobile_number',
                    'guardians.name as guardian_name',
                    'guardians.email as guardian_email',
                    'guardians.mobile_number as guardian_mobile')
            ->get();

        return view('reports.students', [
            'reportType' => 'students_with_guardians',
            'reportTitle' => 'تقرير الطلاب مع أولياء الأمور',
            'data' => $data
        ]);
    }

    public function studentsWithoutGuardians()
    {
        $data = User::where('user_type', '=', 3) // Students
            ->whereNull('guardian_id')
            ->leftJoin('class', 'users.class_id', '=', 'class.id')
            ->select('users.*', 'class.name as class_name')
            ->get();

        return view('reports.students', [
            'reportType' => 'students_without_guardians',
            'reportTitle' => 'تقرير الطلاب بدون أولياء أمور',
            'data' => $data
        ]);
    }

    public function guardiansWithoutStudents()
    {
        $data = User::where('user_type', '=', 4) // Guardians
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                      ->from('users as students')
                      ->whereRaw('students.guardian_id = users.id');
            })
            ->select('users.*')
            ->get();

        return view('reports.students', [
            'reportType' => 'guardians_without_students',
            'reportTitle' => 'تقرير أولياء الأمور بدون طلاب',
            'data' => $data
        ]);
    }

    public function classesWithStudents()
    {
        $data = ClassModel::with(['students' => function($query) {
            $query->select('users.*')
                  ->leftJoin('users as guardians', 'users.guardian_id', '=', 'guardians.id')
                  ->addSelect('guardians.name as guardian_name');
        }])
        ->where('is_delete', 0)
        ->where('status', 0)
        ->get();

        return view('reports.students', [
            'reportType' => 'classes_students',
            'reportTitle' => 'تقرير الفصول والطلاب',
            'data' => $data
        ]);
    }

    public function students(Request $request)
    {
        $reportType = $request->get('report_type', 'students_with_guardians');
        $gradeLevel = $request->get('grade_level');
        
        switch ($reportType) {
            case 'students_with_guardians':
                $data = User::where('users.user_type', '=', 3)
                    ->join('users as guardians', 'users.guardian_id', '=', 'guardians.id')
                    ->select('users.name', 'users.email', 'users.mobile_number',
                            'guardians.name as guardian_name',
                            'guardians.email as guardian_email',
                            'guardians.mobile_number as guardian_mobile')
                    ->get();
                break;

            case 'students_without_guardians':
                $data = User::where('user_type', '=', 3)
                    ->whereNull('guardian_id')
                    ->leftJoin('class', 'users.class_id', '=', 'class.id')
                    ->select('users.*', 'class.name as class_name')
                    ->get();
                break;

            case 'guardians_without_students':
                $data = User::where('user_type', '=', 4)
                    ->whereNotExists(function($query) {
                        $query->select(DB::raw(1))
                              ->from('users as students')
                              ->whereRaw('students.guardian_id = users.id');
                    })
                    ->select('users.*')
                    ->get();
                break;

            case 'classes_students':
                $query = ClassModel::with(['students' => function($query) {
                    $query->select('users.*')
                          ->leftJoin('users as guardians', 'users.guardian_id', '=', 'guardians.id')
                          ->addSelect('guardians.name as guardian_name');
                }])
                ->where('is_delete', 0)
                ->where('status', 0);

                if ($gradeLevel) {
                    $query->where('grade_level', $gradeLevel);
                }

                $data = $query->get();
                break;
        }

        if ($request->get('export')) {
            return Excel::download(new ExportStudent($data, $reportType), 'students_report.xlsx');
        }

        return view('reports.students', [
            'reportType' => $reportType,
            'data' => $data
        ]);
    }

    public function teachers(Request $request)
    {
        $reportType = $request->get('report_type', 'assigned_classes');
        
        switch ($reportType) {
            case 'assigned_classes':
                $data = User::where('users.user_type', '=', 2)
                    ->with(['assignedClasses' => function($query) {
                        $query->where('is_delete', 0);
                    }])
                    ->get();
                break;

            case 'evaluations':
                $data = User::where('users.user_type', '=', 2)
                    ->with('evaluations')
                    ->get();
                break;

            case 'subjects':
                $data = User::where('users.user_type', '=', 2)
                    ->with('subjects')
                    ->get();
                break;
        }

        if ($request->get('export')) {
            return Excel::download(new ExportTeacher($data, $reportType), 'teachers_report.xlsx');
        }

        return view('reports.teachers', [
            'reportType' => $reportType,
            'data' => $data
        ]);
    }

    public function financial(Request $request)
    {
        $reportType = $request->get('report_type', 'pending_fees');
        
        switch ($reportType) {
            case 'pending_fees':
                $data = User::where('users.user_type', '=', 3)
                    ->join('student_fees', 'users.id', '=', 'student_fees.student_id')
                    ->select('users.*', 
                            DB::raw('SUM(student_fees.amount) as total_fees'),
                            DB::raw('SUM(student_fees.paid_amount) as paid_amount'),
                            DB::raw('SUM(student_fees.amount - student_fees.paid_amount) as remaining_amount'))
                    ->groupBy('users.id')
                    ->having('remaining_amount', '>', 0)
                    ->get();
                break;

            case 'completed_fees':
                $data = User::where('user_type', '=', 3)
                    ->join('student_fees', 'users.id', '=', 'student_fees.student_id')
                    ->select('users.*', 
                            DB::raw('SUM(student_fees.amount) as total_fees'),
                            DB::raw('SUM(student_fees.paid_amount) as paid_amount'))
                    ->groupBy('users.id')
                    ->having(DB::raw('SUM(student_fees.amount - student_fees.paid_amount)'), '=', 0)
                    ->get();
                break;

            case 'payment_analysis':
                $data = DB::table('student_fees')
                    ->select('payment_method',
                            DB::raw('COUNT(*) as count'),
                            DB::raw('SUM(paid_amount) as total_amount'),
                            DB::raw('(SUM(paid_amount) / (SELECT SUM(paid_amount) FROM student_fees) * 100) as percentage'))
                    ->groupBy('payment_method')
                    ->get();
                break;
        }

        if ($request->get('export')) {
            return Excel::download(new ExportCollectFees($data, $reportType), 'financial_report.xlsx');
        }

        return view('reports.financial', [
            'reportType' => $reportType,
            'data' => $data
        ]);
    }

    public function examinations(Request $request)
    {
        $reportType = $request->get('report_type', 'performance_analysis');
        $classId = $request->get('class_id');
        
        switch ($reportType) {
            case 'performance_analysis':
                $data = DB::table('exam_results')
                    ->join('users', 'exam_results.student_id', '=', 'users.id')
                    ->where('users.class_id', $classId)
                    ->select('users.name',
                            'exam_results.subject_id',
                            'exam_results.marks',
                            'exam_results.exam_date')
                    ->get();
                break;

            case 'results_comparison':
                $data = DB::table('exam_results')
                    ->join('users', 'exam_results.student_id', '=', 'users.id')
                    ->where('users.class_id', $classId)
                    ->select('users.name',
                            'exam_results.subject_id',
                            'exam_results.marks',
                            'exam_results.exam_date')
                    ->orderBy('exam_results.exam_date', 'desc')
                    ->get();
                break;

            case 'grades_distribution':
                $data = DB::table('exam_results')
                    ->join('users', 'exam_results.student_id', '=', 'users.id')
                    ->where('users.class_id', $classId)
                    ->select(DB::raw('
                        CASE 
                            WHEN marks >= 90 THEN "ممتاز"
                            WHEN marks >= 80 THEN "جيد جداً"
                            WHEN marks >= 70 THEN "جيد"
                            WHEN marks >= 60 THEN "مقبول"
                            ELSE "ضعيف"
                        END as grade'),
                        DB::raw('COUNT(*) as count'),
                        DB::raw('(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM exam_results WHERE class_id = exam_results.class_id)) as percentage'))
                    ->groupBy('grade')
                    ->get();
                break;
        }

        if ($request->get('export')) {
            return Excel::download(new ExportExaminations($data, $reportType), 'examinations_report.xlsx');
        }

        return view('reports.examinations', [
            'reportType' => $reportType,
            'data' => $data,
            'classId' => $classId
        ]);
    }
}