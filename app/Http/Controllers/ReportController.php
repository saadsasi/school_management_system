<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\StudentAddFeesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();
        $totalStudents = User::where('user_type', 3)->count(); // 3 for students
        $totalTeachers = User::where('user_type', 2)->count();
        $totalClasses = ClassModel::count();
        $totalFees = StudentAddFeesModel::sum('paid_amount');
        
        return view('reports.reports', compact('classes', 'totalStudents', 'totalTeachers', 'totalClasses', 'totalFees'));
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
}