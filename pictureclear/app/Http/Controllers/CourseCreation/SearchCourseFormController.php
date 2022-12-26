<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;




class SearchCourseFormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function checkCourse(Request $request) {
        $user = null;
        $find = $request['findCourse'];
        $courses = DB::select('select * from courses where UPPER(title) LIKE UPPER(\'%'.$find.'%\')');
        if($courses){
            $user = DB::select('select * from users where id = '.$courses[0]->owner_id.'');
            if($courses[0]->public || ($courses[0]->owner_id == Auth::id()))         return view('checkCourse', ['checkCourse' => $courses, 'checkUser' => $user])->with('success', '!');
        } 
        return redirect('/home');
    }
}
