<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
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
        $user =  User::select('*')->where('id', '=', Auth::user()->id)->get();
        return view('editProfile', ['user' => $user]);
    }
    public function editProfileSave(Request $request)
    {
        if (!$request->file('image')) {
            DB::update('update users set firstname=?, lastname=?, description=? where id=?', [$request->firstname, $request->lastname, $request->about, Auth::user()->id]);
            return redirect()->back()->with('status', 'info updated');
        }
        $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg'
        ]);


        if (Storage::exists('public/images/' . Auth::user()->picture)) {

            Storage::delete('public/images/' . Auth::user()->picture);
        }

        $request->file('image')->store('public/images');
        DB::update('update users set firstname=?, lastname=?, description=?, picture=? where id=?', [$request->firstname, $request->lastname, $request->about, $request->file('image')->hashName(), Auth::user()->id]);
        return redirect()->back()->with('status', 'info updated'); // redirect to profile
    }
}
