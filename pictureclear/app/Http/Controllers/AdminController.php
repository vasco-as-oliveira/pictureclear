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


    public function courses(Request $request){
        if (!Auth::user()->is_admin) return redirect('https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley');
        $courses = DB::table("courses")->select('*')->paginate(10);
        $number = DB::select("Select count(*) from courses");
        return view('painelAdminCourses', ['courses' => $courses, 'number' => $number]);
    }

    public function users(){
        if (!Auth::user()->is_admin) return redirect('https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley');
        $users = DB::table("users")->select('*')->where('is_admin', false)->paginate(10);
        $number = DB::select("Select count(*) from users");
        return view('painelAdminUsers', ['users' => $users, 'number' => $number]);
    }

    public function deleteCourse(Request $request){
        if (!Auth::user()->is_admin) return redirect('https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley');
        Course::destroy($request->course);
        return redirect(url("/painelAdmin/courses"));
    }

    public function deleteUser(Request $request){
        
        if (!Auth::user()->is_admin) return redirect('https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley');
          User::destroy($request->user);
          return redirect(url("/painelAdmin/users"));
    }
}