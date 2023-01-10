<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Tier;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'IsAdmin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
       

        if($request->dropdown==NULL){
            $courses = Course::select('*')
            ->orderBy('id', 'desc')
            ->paginate(10);
/*
            $courses = DB::table('courses')
            ->select('*')
            ->orderBy('id', 'desc')
            ->paginate(10);
*/
        }else{
            $order = explode('_',$request->dropdown);
            if($order[0]=='price'){
                $courses = Course::select('*')
                ->whereIn('id', Tier::select(DB::raw('course_id as id, MIN(price) as price'))
                            ->groupby('course_id')
                            ->orderby('price',$order[1])
                            ->pluck('id')
                            ->toArray())
                ->orderby('id', $order[1])
                ->paginate(10);

/*              $courses = DB::table('courses')
                ->select('courses.*')
                ->whereIn('id',DB::table('tiers')->select(DB::raw('course_id as id, MIN(price) as price'))->groupby('course_id')->orderby('price',$order[1])->pluck('id')->toArray())
                ->orderby('id', $order[1])
                ->paginate(10);  
*/
            }else{
                $courses = Course::select('*')
                ->orderBy($order[0], $order[1])
                ->paginate(10);
/*              
                $courses = DB::table('courses')
                ->select('*')
                ->orderBy($order[0], $order[1])
                ->paginate(10); 
*/  
            }      
        }
        return view('feed', ['courses'=> $courses]);
    }
}
