<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'OnlyAdmin']);
    }

    public function courses(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return redirect("/home");
        }
        $courses = Course::select('*')->paginate(10);
        $number = Course::count('*');
        return view('painelAdminCourses', ['courses' => $courses, 'number' => $number]);
    }

    public function users()
    {
        if (!Auth::user()->is_admin) {
            return redirect("/home");
        }
        $users = User::select('*')->where('is_admin', false)->paginate(10);
        $number = User::where('is_admin', false)->count();
        return view('painelAdminUsers', ['users' => $users, 'number' => $number]);
    }

    public function deleteCourse(Request $request)
    {
        if (!Auth::user()->is_admin){
            return redirect(url("/home"));
        }
        Course::destroy($request->course);
        return redirect(url("/painelAdmin/courses"));
    }

    public function deleteUser(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return redirect(url("/home"));
        }
        User::destroy($request->user);
        return redirect(url("/painelAdmin/users"));
    }
}