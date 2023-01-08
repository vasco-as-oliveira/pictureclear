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
    public function index(Request $request){
        if (!Auth::user()->is_admin) return redirect('https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley');
        $courses = DB::table("courses")->select('*')->paginate(10);
        $users = DB::table("users")->select('*')->where('is_admin', false)->paginate(10);
        
        return view('painelAdmin', ['courses' => $courses, 'users' => $users, 'section' => $request->section]);
    }

    public function deleteCourse(Request $request){
        if (!Auth::user()->is_admin) return redirect('https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley');
        Course::destroy($request->course);
        return redirect(url("/painelAdmin?section=2"));
    }

    public function deleteUser(Request $request){
        
        if (!Auth::user()->is_admin) return redirect('https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley');
          // Course::where('owner_id', '=', $request->user)->delete();
        
          User::destroy($request->user);
           
            return redirect(url("/painelAdmin?section=1"));
    }
}