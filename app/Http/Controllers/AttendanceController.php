<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\StudentAttendanceModel;
use App\Models\AssignClassTeacherModel;
use App\Exports\ExportAttendance;
use Auth;
use Excel;


class AttendanceController extends Controller
{
    public function AttendanceStudent(Request $request)
    {
        $data['getClass'] = [];

        if ($request->get('grade_level')) {
            $data['getClass'] = ClassModel::where('grade_level', $request->get('grade_level'))
                ->where('is_delete', 0)
                ->where('status', 0)
                ->orderBy('name', 'asc')
                ->get();
        }

        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }

        $data['header_title'] = "Student Attendance";
        return view('admin.attendance.student', $data);
    }

    public function AttendanceStudentSubmit(Request $request)
    {
        $attendance_data = $request->attendance_data;
        $success_count = 0;

        foreach ($attendance_data as $data) {
            $check_attendance = StudentAttendanceModel::CheckAlreadyAttendance($data['student_id'], $request->class_id, $request->attendance_date);

            if (!empty($check_attendance)) {
                $attendance = $check_attendance;
            } else {
                $attendance = new StudentAttendanceModel;
                $attendance->student_id = $data['student_id'];
                $attendance->class_id = $request->class_id;
                $attendance->attendance_date = $request->attendance_date;
                $attendance->created_by = Auth::user()->id;
            }

            $attendance->attendance_type = $data['attendance_type'];
            $attendance->notes = $data['notes'] ?? null;
            $attendance->save();

            $success_count++;
        }

        $json['message'] = $success_count . __('messages.student_attendance_records_successfully_saved');
        return response()->json($json);
    }


    public function AttendanceReport(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getRecord'] = StudentAttendanceModel::getRecord();
        $data['header_title'] = "Attendance Report";
        return view('admin.attendance.report', $data);
    }

    public function AttendanceReportExportExcel(Request $request)
    {
        return Excel::download(new ExportAttendance, 'AttendanceReport_' . date('d-m-Y') . '.xls');
    }

    // teacher side

    public function AttendanceStudentTeacher(Request $request)
    {
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }

        $data['header_title'] = "Student Attendance";
        return view('teacher.attendance.student', $data);
    }



    public function AttendanceReportTeacher(Request $request)
    {
        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        $classarrray = array();
        foreach ($getClass as $value) {
            $classarrray[] = $value->class_id;
        }


        $data['getClass'] = $getClass;
        $data['getRecord'] = StudentAttendanceModel::getRecordTeacher($classarrray);
        $data['header_title'] = "Attendance Report";
        return view('teacher.attendance.report', $data);
    }

    // student side work

    public function MyAttendanceStudent()
    {
        $data['getClass'] = StudentAttendanceModel::getClassStudent(Auth::user()->id);
        $data['getRecord'] = StudentAttendanceModel::getRecordStudent(Auth::user()->id);
        $data['header_title'] = "My Attendance";
        return view('student.my_attendance', $data);
    }


    // parent side work

    public function MyAttendanceParent($student_id)
    {
        $data['getStudent'] = User::getSingle($student_id);
        $data['getClass'] = StudentAttendanceModel::getClassStudent($student_id);
        $data['getRecord'] = StudentAttendanceModel::getRecordStudent($student_id);
        $data['header_title'] = "Student Attendance";
        return view('parent.my_attendance', $data);
    }

    public function getClassesByGrade($grade_level)
    {
        $classes = ClassModel::where('grade_level', $grade_level)
            ->where('is_delete', 0)
            ->where('status', 0)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($classes);
    }
}
