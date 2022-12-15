<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;

class TierFormController extends Controller
{
    public function createForm(Request $request) {
        return view('createTier');
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'checktier']);
    }


    public function CreateCourseForm(Request $request) {
        // Form validation
        $request->validate([
            
         ]);
        

        //  Store data in database
        Course::insert(array(
            
        ));
        
        // 
        return back()->with('success', 'Acabaste de iniciar o teu curso!');
    }
}
