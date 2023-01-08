<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
            $courses = DB::table('courses')
            ->select('*')
            ->orderBy('id', 'desc')
            ->paginate(10);

        }else{
            $order = explode('_',$request->dropdown);
            if($order[0]=='price'){
                $courses = DB::table('courses')
                ->select('courses.*')
                ->whereIn('id',DB::table('tiers')->select(DB::raw('course_id as id, MIN(price) as price'))->groupby('course_id')->orderby('price',$order[1])->pluck('id')->toArray())
                ->orderby('id', $order[1])
                ->paginate(10); 
            }else{
                $courses = DB::table('courses')
                ->select('*')
                ->orderBy($order[0], $order[1])
                ->paginate(10);   
            }      
        }
        

        return view('feed', ['courses'=> $courses]);
    }

    
    public function changeOrder(Request $request)
    {
        $order = explode("_",$request->dropdown);
        $courses = DB::table('courses')->select('*')->orderBy($order[1], $order[0])->paginate(10);
        return view('feed', ['courses'=> $courses]);
    }
}
