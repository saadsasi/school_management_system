<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityRegistration;
use Illuminate\Http\Request;
use Auth;

class ActivityController extends Controller
{
    public function index()
    {
        $data['header_title'] = "إدارة الأنشطة";
        $data['activities'] = Activity::orderBy('id', 'desc')->get();
        return view('admin.activity.list', $data);
    }

    public function create()
    {
        $data['header_title'] = "إضافة نشاط جديد";
        return view('admin.activity.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_students' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0'
        ]);

        Activity::create($request->all());
        return redirect('admin/activities')->with('success', 'تم إضافة النشاط بنجاح');
    }

    public function registrations()
    {
        $data['header_title'] = "طلبات التسجيل في الأنشطة";
        $data['registrations'] = ActivityRegistration::with(['activity', 'student'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.activity.registrations', $data);
    }

    public function updateRegistrationStatus(Request $request, $id)
    {
        try {
            $registration = ActivityRegistration::findOrFail($id);
            $registration->status = $request->status;
            $registration->approved_at = now();
            $registration->approved_by = auth()->id();
            $registration->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة التسجيل بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث حالة التسجيل'
            ], 500);
        }
    }
}