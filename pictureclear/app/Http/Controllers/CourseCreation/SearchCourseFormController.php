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
        //$courses = DB::select('select * from courses where UPPER(title) LIKE UPPER(\'%'.$find.'%\')');
        $courses = Course::select('*')
                    ->where('title', 'ilike', '%'.$find.'%')->get()->toArray();
        
        if($courses){
            $numOfCourses = count($courses);
            if($numOfCourses>1){
                return view('listCourses', ['checkCourse' => $courses])->with('success', '!');
            } else if($numOfCourses == 1) {

                return redirect('checkCourse/search?selectCourse=' . $courses[0]['id']);
            }
        }
        return redirect('/home');
    }
}
