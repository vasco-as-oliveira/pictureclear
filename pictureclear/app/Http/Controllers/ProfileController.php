<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Course;
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
    
    public function showProfile(Request $request){
        $user = User::select('*')->where('username','=',$request->username)->get();
        $courses = null;
        $active = 0;

        if($request['coursesSelected'] == "coursesSelected1"){
            $courses = DB::select("SELECT * from courses where owner_id =". $user[0]->id);
        } else if ($request['coursesSelected'] == "coursesSelected2") {

            $courses = DB::select("SELECT * from courses where id IN(
                select course_id from tiers where id IN(
                    select tier_id from sales where user_id = ?
                )
            )", [$user[0]->id]);

            $active = 1;
        } else {
            $courses = DB::select("SELECT * from courses where owner_id =". $user[0]->id);
        }

        $aux_array = array();
        if (count($courses)){
            foreach ($courses as $course){
                $price = DB::select("SELECT MIN(price) FROM tiers WHERE course_id=".$course->id);
                 $aux_array[$course->title] = $price[0]->min; 
             }
        }
        
        if (!$user) return redirect()->back()->with('status', 'Error');
        return view('profile', ['user'=>$user, 'courses' => $courses, 'prices' => $aux_array, 'active' => $active]);
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
       
        DB::update('update users set firstname=?, lastname=?, description=? where id=?',
            [$request->firstname, $request->lastname, $request->about, Auth::user()->id]);
            
        if ($request->file('image')) {
            $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg'
            ]);

            if (Storage::exists('public/images/' . Auth::user()->picture)) {
                Storage::delete('public/images/' . Auth::user()->picture);
            }

            $request->file('image')->store('public/images');
            DB::update('update users set picture=? where id=?',
                    [ $request->file('image')->hashName(), Auth::user()->id]);
        
        }
    return redirect(url("/profile/?username=" . Auth::user()->username));
    }
}