<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class LessonFormController extends Controller
{

    
    public function createForm(Request $request, $id) {
        return view('lessonCreate', ['id'=>$id]);
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function LessonForm(Request $request, $id) {
        // Form validation

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        
        if ($request->hasFile('inputvideo'))
        {
        $path = $request->file('inputvideo')->store('public/images');
        
        Lesson::insertGetId(array(
            'course_id' => $id,
            'title' => $request['title'],
            'description' => $request['description'],
            'url' => $request->file('inputvideo')->hashName(),
         ));
        }

        

        // 
        return redirect('/')->with('success', 'Acabaste de iniciar o teu curso!');
    }
}
