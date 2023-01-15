<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use App\Models\User as UserDb;



class AboutYouController extends Controller
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
    public function index()
    {
        $user =  UserDb::select('finished_setup')->where('id', '=', Auth::user()->id)->get();
        if ($user->value('finished_setup')) {
            return redirect('home');
        }
        return view('aboutyou');
    }

    public function finishSetup(Request $request)
    {
        if (!empty($request->input('description'))) {
            $request->validate([
                'description' => ['string', 'max:150'],
            ]);
            UserDb::find(Auth::user()->id)->update(['description'=> $request->description]);
        }

        if ($request->file('inputImage') != null) {
            $request->validate([
                'inputImage' => ['image','mimes:png,jpg,jpeg'],
            ]);
            $request->file('inputImage')->store('public/images');
            UserDb::find(Auth::user()->id)->update(['picture'=>$request->file('inputImage')->hashName()]);
        }

        UserDb::find(Auth::user()->id)->update(['finished_setup'=> true]);
        return redirect('home');
    }

}
