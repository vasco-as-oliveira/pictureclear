<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;


class CreateCourseFormController extends Controller
{
    public function createForm(Request $request) {
        return view('createCourse');
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function CreateCourseForm(Request $request) {
        $certificate = false;
        if($request['has_certificate'] == 'true') $certificate = true;
        // Form validation

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'language' => 'required',
         ]);
        

        //  Store data in database
        Course::insert(array(
            'owner_id' => Auth::id(),
            'title' => $request['title'],
            'language' => $request['language'],
            'description' => $request['description'],
            'rating' => 0,
            'has_certificate' => $certificate,
            'total_hours' => 1,
        ));
        
        // 
        return view()->with('success', 'Acabaste de iniciar o teu curso!');
    }
}
