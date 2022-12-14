<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;


class AboutYouController extends Controller
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
        $user =  User::select('finished_setup')->where('id','=',Auth::user()->id)->get();
        if($user->value('finished_setup')){
            return redirect('home');
        }

        return view('aboutyou');
    }

    public function finishSetup(Request $request)
    {
        $request->validate([
            'description' => ['string', 'max:150'],
            'inputImage' => ['image','mimes:png,jpg,jpeg'],
        ]);
        
        $request->file('inputImage')->store('public/images');
        DB::update("update users set description=?, picture =?, finished_setup='t' where id=?", [$request->description,$request->file('inputImage')->hashName() ,Auth::user()->id]);
        
        return redirect('home');
    }
}
