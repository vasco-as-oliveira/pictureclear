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
use Illuminate\Support\Facades\Storage;




class LessonFormController extends Controller
{

    
    public function createForm(Request $request, $id) {
        return view('lessonCreate', ['id'=>$id]);
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'IsAdmin']);
    }

    public function LessonForm(Request $request, $id) {
        // Form validation
    
        $file = $request->file('inputvideo')->get();

        if($request->file('inputvideo') != null){
            $request->validate([
                'inputvideo'  => 'mimes:mp4,mov,ogg,qt,mkv | max:20000',
            ]);
            $request->file('inputvideo')->store('public/videos');
            //Storage::disk('local')->put('public/videos/'.$request->file('inputvideo')->hashName(), $file);
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        
        Lesson::insertGetId(array(
            'course_id' => $id,
            'title' => $request['title'],
            'description' => $request['description'],
            'url' => $request->file('inputvideo')->hashName(),
        ));
        

        
        return redirect('/profile?username='.Auth::user()->username)->with('success', 'Acabaste de iniciar o teu curso!');
    }
}
