<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Mail;
use Str;

class AuthController extends Controller
{
    public function login()
    {
        if (!empty(Auth::check())) {
            if (Auth::user()->user_type == 1) {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->user_type == 2) {
                return redirect('teacher/dashboard');
            } elseif (Auth::user()->user_type == 3) {
                return redirect('student/my_calendar');
            } elseif (Auth::user()->user_type == 4) {
                return redirect('parent/dashboard');
            }
        }

        return view('auth.login');
    }

    public function AuthLogin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            if (Auth::user()->user_type == 1) {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->user_type == 2) {
                return redirect('teacher/dashboard');
            } elseif (Auth::user()->user_type == 3) {
                return redirect('student/my_calendar');
            } elseif (Auth::user()->user_type == 4) {
                return redirect('parent/dashboard');
            }
        } else {
            return redirect()->back()->with('error', __('messages.Please_enter_correct_email_and_password'));
        }
    }

    public function forgotpassword()
    {
        return view('auth.forgot');
    }

    public function PostForgotPassword(Request $request)
    {
        $user = User::getEmailSingle($request->email);
        if (!empty($user)) {
            $user->remember_token = Str::random(30);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', __('messages.Please_check_your_email_and_reset_your_password'));
        } else {
            return redirect()->back()->with('error', __('messages.Email_not_found_in_the_system'));
        }
    }

    public function reset($remember_token)
    {
        $user = User::getTokenSingle($remember_token);
        if (!empty($user)) {
            $data['user'] = $user;
            return view('auth.reset', $data);
        } else {
            abort(404);
        }
    }

    public function PostReset($token, Request $request)
    {
        if ($request->password == $request->cpassword) {
            $user = User::getTokenSingle($token);
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();

            return redirect(url(''))->with('success', __('messages.Password_successfully_reset'));
        } else {
            return redirect()->back()->with('error', __('messages.Password_and_confirm_password_do_not_match'));
        }
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'user_type' => 'required|in:teacher,student,parent',
            'gender' => 'required|in:Male,Female',
            'mobile_number' => 'required',
            'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ]);

        if ($request->user_type == 'student') {
            $request->validate([
                'grade_level' => 'required|in:first_primary,second_primary,third_primary,fourth_primary,fifth_primary,sixth_primary,first_preparatory,second_preparatory,third_preparatory',
                'date_of_birth' => 'required|date',
            ]);
        } elseif ($request->user_type == 'teacher') {
            $request->validate([
                'qualification' => 'required',
            ]);
        }
        $user = new User();

        $profile_pic = null;
        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile/', $filename);

            $user->profile_pic = $filename;
        }

        // Map string user type to numeric value
        $userTypeMap = [
            'teacher' => 2,
            'student' => 3,
            'parent' => 4
        ];

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = $userTypeMap[$request->user_type];
        $user->gender = $request->gender;
        $user->mobile_number = $request->mobile_number;
        $user->status = 1;

        if ($request->user_type == 'student') {
            $user->grade_level = $request->grade_level;
            $user->date_of_birth = $request->date_of_birth;
        } elseif ($request->user_type == 'teacher') {
            $user->qualification = $request->qualification;
            $user->work_experience = $request->work_experience;
        } elseif ($request->user_type == 'parent') {
            $user->occupation = $request->occupation;
            $user->address = $request->address;
        }

        $user->save();
        return redirect(url('/'))->with('success', __('messages.common.success'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }
}
