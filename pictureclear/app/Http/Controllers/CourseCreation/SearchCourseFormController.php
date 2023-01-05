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
            $numOfCourses = count($courses);
            if($numOfCourses>1){
                return view('listCourses', ['checkCourse' => $courses])->with('success', '!');
            } else if($numOfCourses == 1) {
                $user = DB::select('select * from users where id = '.$courses[0]->owner_id.'');
                if($courses[0]->owner_id == Auth::id()){
                    return view('coursePageOwner', ['checkCourse' => $courses[0], 'checkUser' => $user[0]]);
                } else if($courses[0]->public) {
                    return view('checkCourse', ['checkCourse' => $courses[0], 'checkUser' => $user[0]]);
                }
            }
        }
        return redirect('/home');
    }
}
