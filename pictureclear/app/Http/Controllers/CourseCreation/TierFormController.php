<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;

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
        if($request['chooseTier1']=='true'){
            // Form validation
            $request->validate([
                        
            ]);
            //  Store data in database
            Tier::insert(array(
                'course_id' => $request->session()->get('tier'),
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
                'course_id' => $request->session()->get('tier'),
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
                'course_id' => $request->session()->get('tier'),
                'price' => $request['price3'],
                'hasSchedulePerk' => true,
                'hasChatPerk' => true,
            ));
        }

        
        $request->session()->remove('tier');
        // 
        return view('home')->with('success', 'Acabaste de iniciar o teu curso!');
    }
}
