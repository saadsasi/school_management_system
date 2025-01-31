<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityRegistration;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Lang;

class ActivityController extends Controller
{
    public function index()
    {
        $data['header_title'] = "activities";
        $data['activities'] = Activity::withCount('registrations')->orderBy('id', 'desc')->get();
        return view('admin.activity.list', $data);
    }

    public function create()
    {
        $data['header_title'] = "add activity";
        $data['getWeek'] = DB::table('week')->get();
        return view('admin.activity.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_students' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'schedule' => 'required|array|min:1',
            'schedule.*.week_id' => 'required|exists:week,id',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i|after:schedule.*.start_time',
            'schedule.*.location' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // Create activity
            $activity = Activity::create([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'max_students' => $request->max_students,
                'cost' => $request->cost,
                'status' => $request->status ?? 'active'
            ]);

            // Create schedules
            foreach ($request->schedule as $schedule) {
                DB::table('activity_schedule')->insert([
                    'activity_id' => $activity->id,
                    'week_id' => $schedule['week_id'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                    'location' => $schedule['location'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            return redirect('admin/activities')->with('success', __('messages.activity_added_successfully'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', __('messages.error_adding_activity'))->withInput();
        }
    }

    public function edit($id)
    {
        $data['header_title'] = "edit activity";
        $data['activity'] = Activity::findOrFail($id);
        $data['schedules'] = DB::table('activity_schedule')->where('activity_id', $id)->get();
        $data['getWeek'] = DB::table('week')->get();
        return view('admin.activity.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_students' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'schedule' => 'required|array|min:1',
            'schedule.*.week_id' => 'required|exists:week,id',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i|after:schedule.*.start_time',
            'schedule.*.location' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // Update activity
            $activity = Activity::findOrFail($id);
            $activity->update([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'max_students' => $request->max_students,
                'cost' => $request->cost,
                'status' => $request->status ?? 'active'
            ]);

            // Delete old schedules
            DB::table('activity_schedule')->where('activity_id', $id)->delete();

            // Create new schedules
            foreach ($request->schedule as $schedule) {
                DB::table('activity_schedule')->insert([
                    'activity_id' => $activity->id,
                    'week_id' => $schedule['week_id'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                    'location' => $schedule['location'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            return redirect('admin/activities')->with('success', __('messages.activity_updated_successfully'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', __('messages.error_updating_activity'))->withInput();
        }
    }

    public function registrations()
    {
        $data['header_title'] = "my activities";
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
                'message' => __('messages.registration_status_updated_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.error_updating_registration_status')
            ], 500);
        }
    }

    public function myActivities()
    {
        $data['header_title'] = "my activities";
        $data['activities'] = ActivityRegistration::where('student_id', Auth::user()->id)
            ->with(['activity' => function($q) {
                $q->with('schedules');
            }])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('student.activities', $data);
    }
}