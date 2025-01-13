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
                return redirect('student/dashboard');
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
                return redirect('student/dashboard');
            } elseif (Auth::user()->user_type == 4) {
                return redirect('parent/dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Please enter correct email and password');
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

            return redirect()->back()->with('success', "Please check your email and reset your password");
        } else {
            return redirect()->back()->with('error', "Email not found in the system.");
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

            return redirect(url(''))->with('success', "Password successfully reset");
        } else {
            return redirect()->back()->with('error', "Password and confirm password do not match");
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
        ]);


        if ($request->user_type == 'student') {
            $request->validate([
                'admission_number' => 'required|unique:users',
                'class_id' => 'required|exists:class,id',
                'date_of_birth' => 'required|date',
            ]);
        } elseif ($request->user_type == 'teacher') {
            $request->validate([
                'qualification' => 'required',
            ]);
        }

        $profile_pic = null;
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('upload/profile/', $filename);
            $profile_pic = 'upload/profile/' . $filename;
        }

        // Map string user type to numeric value
        $userTypeMap = [
            'teacher' => 2,
            'student' => 3,
            'parent' => 4
        ];

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $userTypeMap[$request->user_type],
            'gender' => $request->gender,
            'mobile_number' => $request->mobile_number,
            'profile_pic' => $profile_pic,
        ]);

        if ($request->user_type == 'student') {
            $user->admission_number = $request->admission_number;
            $user->class_id = $request->class_id;
            $user->roll_number = $request->roll_number;
            $user->date_of_birth = $request->date_of_birth;
        } elseif ($request->user_type == 'teacher') {
            $user->qualification = $request->qualification;
            $user->work_experience = $request->work_experience;
        } elseif ($request->user_type == 'parent') {
            $user->occupation = $request->occupation;
            $user->address = $request->address;
        }
        $user->status = 1;
        $user->save();

        return redirect(url('/'))->with('success', "Registration successfully completed,wait for approvel");
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }
}
