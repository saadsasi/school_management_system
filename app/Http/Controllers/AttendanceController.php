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
        $data['getClass'] = ClassModel::getClass();

        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date')))
        {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }

        $data['header_title'] = "Student Attendance";
        return view('admin.attendance.student', $data);
    }

    public function AttendanceStudentSubmit(Request $request)
    {

        $check_attendance = StudentAttendanceModel::CheckAlreadyAttendance($request->student_id, $request->class_id, $request->attendance_date);

        if(!empty($check_attendance))
        {
            $attendance = $check_attendance;
        }
        else
        {
            $attendance = new StudentAttendanceModel;
            $attendance->student_id = $request->student_id;
            $attendance->class_id = $request->class_id;
            $attendance->attendance_date = $request->attendance_date;
            $attendance->created_by = Auth::user()->id;
        }

        $attendance->attendance_type = $request->attendance_type;
        $attendance->save();

        $json['message'] = "Attendance Successfully Saved";

        echo json_encode($json);
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
        return Excel::download(new ExportAttendance, 'AttendanceReport_'.date('d-m-Y').'.xls');
    }

    // teacher side

    public function AttendanceStudentTeacher(Request $request)
    {
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        
        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date')))
        {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }

        $data['header_title'] = "Student Attendance";
        return view('teacher.attendance.student', $data);
    }



    public function AttendanceReportTeacher(Request $request)
    {
        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        $classarrray = array();
        foreach($getClass as $value)
        {
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
}
