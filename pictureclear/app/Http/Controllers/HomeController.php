<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        /*
        $allSessions = session()->all();
        dd($allSessions);
        */
        //return view('home');
        return view('feed');
    }

    public function showCourses(Request $request){
        $courses = DB::table('courses')->select('*')->get();

    }
}
