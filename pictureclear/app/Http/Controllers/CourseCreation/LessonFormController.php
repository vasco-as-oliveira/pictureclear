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

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'inputvideo'  => 'mimes:mp4,mov,ogg,qt | max:20000'
        ]);

        $fileName = $request->file('inputvideo')->hashName();
        $targetDirectory = "/public/videos/";
        $path = Storage::url($targetDirectory . $fileName);
        
        if (str_starts_with($path,  '/storage/'.$targetDirectory)) {
            $file = file_get_contents($targetDirectory . $fileName);            
            Storage::disk('local')->put($targetDirectory . $fileName, $file);
        }
        
        Lesson::insertGetId(array(
            'course_id' => $id,
            'title' => $request['title'],
            'description' => $request['description'],
            'url' => $request->file('inputvideo')->hashName(),
        ));
        

        
        return redirect('/profile?username='.Auth::user()->username)->with('success', 'Acabaste de iniciar o teu curso!');
    }
}
