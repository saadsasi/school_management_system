<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Auth;

class LeaveController extends Controller
{
    // ثوابت أنواع المغادرة
    const LEAVE_TYPE_EARLY = 'early_leave';
    const LEAVE_TYPE_END_DAY = 'end_day_leave';
    const LEAVE_TYPE_FULL_DAY = 'full_day_leave'; // إضافة نوع جديد للمغادرة
      
    public function requests()
    {
        $data['header_title'] = "طلبات المغادرة";
        $data['getRecord'] = LeaveRequest::with('user')
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.leave.requests', $data);
    }

    public function approve($id)
    {
        $leave = LeaveRequest::find($id);
        if(!empty($leave)) {
            $leave->status = 1;
            $leave->save();
            return redirect()->back()->with('success', 'تمت الموافقة على الطلب بنجاح');
        }
        return redirect()->back()->with('error', 'حدث خطأ ما');
    }

    public function reject($id)
    {
        $leave = LeaveRequest::find($id);
        if(!empty($leave)) {
            $leave->status = 2;
            $leave->save();
            return redirect()->back()->with('success', 'تم رفض الطلب بنجاح');
        }
        return redirect()->back()->with('error', 'حدث خطأ ما');
    }

    public function delete($id)
    {
        $leave = LeaveRequest::find($id);
        if(!empty($leave)) {
            $leave->delete();
            return redirect()->back()->with('success', 'تم حذف الطلب بنجاح');
        }
        return redirect()->back()->with('error', 'حدث خطأ ما');
    }

    // دوال الطالب
    public function addStudent()
    {
        $data['header_title'] = "طلب مغادرة جديد";
        return view('student.leave.add', $data);
    }

    public function insertStudent(Request $request)
    {
        $leave = new LeaveRequest;
        $leave->user_id = Auth::user()->id;
        $leave->user_type = 'student';
        $leave->type = $request->type;
        $leave->date = $request->date;
        $leave->time = $request->time;
        $leave->reason = $request->reason;
        $leave->status = 0; // قيد الانتظار
        $leave->created_by = Auth::user()->id;
        $leave->save();

        return redirect()->back()->with('success', 'تم إرسال طلب المغادرة بنجاح');
    }

    public function historyStudent()
    {
        $data['header_title'] = "سجل طلبات المغادرة";
        $data['getRecord'] = LeaveRequest::where('user_id', Auth::user()->id)
            ->where('user_type', 'student')
            ->orderBy('id', 'desc')
            ->get();
        return view('student.leave.history', $data);
    }

    // دوال المعلم
    public function addTeacher()
    {
        $data['header_title'] = "طلب مغادرة جديد";
        return view('teacher.leave.add', $data);
    }

    public function insertTeacher(Request $request)
    {
        $leave = new LeaveRequest;
        $leave->user_id = Auth::user()->id;
        $leave->user_type = 'teacher';
        $leave->type = $request->type;
        $leave->date = $request->date;
        $leave->time = $request->time;
        $leave->reason = $request->reason;
        $leave->status = 0; // قيد الانتظار
        $leave->created_by = Auth::user()->id;
        $leave->save();

        return redirect()->back()->with('success', 'تم إرسال طلب المغادرة بنجاح');
    }

    public function historyTeacher()
    {
        $data['header_title'] = "سجل طلبات المغادرة";
        $data['getRecord'] = LeaveRequest::where('user_id', Auth::user()->id)
            ->where('user_type', 'teacher')
            ->orderBy('id', 'desc')
            ->get();
        return view('teacher.leave.history', $data);
    }
}