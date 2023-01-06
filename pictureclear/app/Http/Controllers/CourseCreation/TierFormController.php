<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Chats;
use App\Models\Course;


class TierFormController extends Controller
{
    public function createForm(Request $request) {
        return view('createcourse');
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'checktier']);
    }


    public function CreateCourseForm(Request $request) {
        $getCourse = $request->session()->get('course');
        //  Store data in database
        $id=Course::insertGetId(array(
            'owner_id' => Auth::id(),
            'title' => $getCourse['title'],
            'language' => $getCourse['language'],
            'description' => $getCourse['description'],
            'rating' => 0,
            'has_certificate' => $getCourse['certificate'],
            'total_hours' => 1,
        ));



        if($request['chooseTier1']=='true'){
            // Form validation
            $request->validate([
                        
            ]);
            //  Store data in database
            Tier::insert(array(
                'course_id' => $id,
                'price' => $request['price1'],
                'hasSchedulePerk' => false,
                'hasChatPerk' => false,
            ));
        }

        if($request['chooseTier2']=='true'){
            // Form validation
            $request->validate([
                        
            ]);


            //  Store data in database
            Tier::insert(array(
                'course_id' => $id,
                'price' => $request['price2'],
                'hasSchedulePerk' => false,
                'hasChatPerk' => true,
            ));
        }

        if($request['chooseTier3']=='true'){
            // Form validation
            $request->validate([
                        
            ]);


            //  Store data in database
            Tier::insert(array(
                'course_id' => $id,
                'price' => $request['price3'],
                'hasSchedulePerk' => true,
                'hasChatPerk' => true,
            ));

          
        }

        $request->session()->remove('course');
        $request->session()->remove('tier');
        // 
        return redirect('/addLesson/'.$id)->with('success', 'Acabaste de iniciar o teu curso!');
    }
}
