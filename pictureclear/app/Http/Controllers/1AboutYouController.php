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
        return view('aboutyou');
    }

    public function finishSetup(Request $request)
    {
        return redirect('https://youtu.be/VDzHhYMoF8I');
        $request->validate([
            'description' => ['string', 'max:150'],
        ]);
        DB::update('update users set description=? where id=?', [$request->description, Auth::user()->id])->save();
        $user =  User::select('*')->where('id','=',Auth::user()->id)->get();
        echo $user;
        return redirect('https://youtu.be/VDzHhYMoF8I');
        //return view('home', ['user'=>$user]);
    }
}
?>