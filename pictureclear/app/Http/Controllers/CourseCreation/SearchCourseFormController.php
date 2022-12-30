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
            if($courses[0]->public || ($courses[0]->owner_id == Auth::id())){
                $rating = DB::select('select * from course_ratings where user_id=? and course_id =? ', [Auth::id(), $courses[0]->id]);
                return view('checkCourse', ['checkCourse' => $courses, 'checkUser' => $user, 'checkRating'=> $rating])->with('success', '!');
            }
        } 
        return redirect('/home');
    }
}
