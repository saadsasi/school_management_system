<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityRegistration;
use Illuminate\Http\Request;
use Auth;

class ParentActivityController extends Controller
{
    public function index()
    {
        $data['header_title'] = "الأنشطة المتاحة";
        $data['activities'] = Activity::where('status', 'active')
            ->where('end_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->get();
        return view('parent.activity.list', $data);
    }

    public function register($activity_id)
    {
        $data['header_title'] = "تسجيل في نشاط";
        $data['activity'] = Activity::findOrFail($activity_id);
        $data['children'] = Auth::user()->children;
        return view('parent.activity.register', $data);
    }

    public function storeRegistration(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'student_id' => 'required|exists:users,id',
            'notes' => 'nullable|string'
        ]);

        // التحقق من عدم وجود تسجيل سابق
        $exists = ActivityRegistration::where('activity_id', $request->activity_id)
            ->where('student_id', $request->student_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'الطالب مسجل مسبقاً في هذا النشاط');
        }

        ActivityRegistration::create($request->all());
        return redirect('parent/activities')->with('success', 'تم تسجيل الطلب بنجاح');
    }

    public function myRegistrations()
    {
        $data['header_title'] = "تسجيلاتي في الأنشطة";
        $children_ids = Auth::user()->children->pluck('id');
        
        $data['registrations'] = ActivityRegistration::whereIn('student_id', $children_ids)
            ->with(['activity', 'student'])
            ->orderBy('id', 'desc')
            ->get();
            
        return view('parent.activity.my_registrations', $data);
    }
}