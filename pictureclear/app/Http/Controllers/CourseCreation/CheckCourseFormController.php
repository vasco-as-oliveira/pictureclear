<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;




class CheckCourseFormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function checkCourse(Request $request) {
        $user = null;
        $find = $request['findCourse'];
        $courses = DB::select('select * from courses where UPPER(title) LIKE UPPER(\'%'.$find.'%\')');
        if($courses)$user = DB::select('select * from users where id = '.$courses[0]->owner_id.'');
        return view('checkCourse', ['checkCourse' => $courses, 'checkUser' => $user])->with('success', '!');
    }

    public function viewCourse(Request $request) {
        $user = null;
        $find = $request['selectCourse'];
        $course = DB::select('select * from courses where id = '.$find.'');
        if($course)$user = DB::select('select * from users where id = '.$course[0]->owner_id.'');
        return view('checkCourse', ['checkCourse' => $course, 'checkUser' => $user])->with('success', '!');
    }

    public function finishSetup(Request $request, $id)
    {
        /*
        $request->validate([
            'description' => ['string', 'max:150'],
            'inputImage' => ['image','mimes:png,jpg,jpeg'],
        ]);
        */
        if(!empty($request->input('description'))){
            $request->validate([
                'description' => ['string', 'max:150'],
            ]);
            DB::update("update courses set description=? where id=?", [$request->description, $id]);
        }

        if($request->file('inputImage') != null){
            $request->validate([
                'inputImage' => ['image','mimes:png,jpg,jpeg'],
            ]);
            $request->file('inputImage')->store('public/images');
            DB::update("update courses set image =? where id=?", [$request->file('inputImage')->hashName(), $id]);
        }

        return back();
    }
}