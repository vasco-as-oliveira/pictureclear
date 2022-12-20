<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class CreateCourseFormController extends Controller
{

    
    public function createForm(Request $request) {
        return view('createCourse');
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'IsTierBeingUsed']);
    }

    public function CreateCourseForm(Request $request) {
        $certificate = false;
        if($request['has_certificate'] == 'true') $certificate = true;
        // Form validation

        $course = array('id'=>Auth::id(), 'title' => $request['title'], 'language' => $request['language'], 'description' => $request['description'],'certificate' => $certificate);
        
        $request->session()->put(['course' => $course]);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'language' => 'required',
         ]);
        

        

        $request->session()->put('tier', 'true');
        
        
        // 
        return redirect('/course/tier')->with('success', 'Acabaste de iniciar o teu curso!');
    }
}
