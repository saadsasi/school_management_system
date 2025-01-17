<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\User;
use Auth;
use DB;
use Log;

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

    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_ids' => 'required|array',
                'student_ids.*' => 'exists:users,id',
                'type' => 'required',
                'reason' => 'required'
            ]);

            // التحقق من أن جميع الطلاب المختارين هم أبناء ولي الأمر
            $parent_id = auth()->id();
            $parent_children = User::where('parent_id', $parent_id)->pluck('id')->toArray();
            
            foreach($request->student_ids as $student_id) {
                if (!in_array($student_id, $parent_children)) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'عذراً، لا يمكنك اختيار طلاب ليسوا من أبنائك');
                }
            }

            DB::beginTransaction();
            
            // إنشاء طلب مغادرة لكل طالب
            foreach($request->student_ids as $student_id) {
                $leave = new LeaveRequest();
                $leave->user_id = $student_id;
                $leave->user_type = 'student';
                $leave->parent_id = $parent_id;
                $leave->type = $request->type;
                $leave->reason = $request->reason;
                $leave->status = 0; // قيد الانتظار
                $leave->created_by = $parent_id;
                $leave->save();

                Log::info('تم إنشاء طلب مغادرة', [
                    'leave_id' => $leave->id,
                    'student_id' => $student_id,
                    'parent_id' => $parent_id
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('parent.leave.my-leaves')
                ->with('success', 'تم إرسال طلب المغادرة بنجاح');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->validator);
                
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('خطأ في إنشاء طلب المغادرة: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء حفظ الطلب. الرجاء المحاولة مرة أخرى.');
        }
    }
}