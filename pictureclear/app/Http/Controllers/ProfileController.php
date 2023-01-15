<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Course as Course;
use App\Models\Sale;
use App\Models\Tier;
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
    
    public function showProfile(Request $request){
        $user = User::select('*')->where('username','=',$request->username)->get()->toArray();
        $courses = null;
        $active = 0;

        if($request['coursesSelected'] == "coursesSelected1"){
            //$courses = DB::select("SELECT * from courses where owner_id =". $user[0]->id);
            $courses = Course::select('*')
                        ->where('owner_id', '=',  $user[0]['id'])->get()->toArray();
        } else if ($request['coursesSelected'] == "coursesSelected2") {

            /* $courses = DB::select("SELECT * from courses where id IN(
                select course_id from tiers where id IN(
                    select tier_id from sales where user_id = ?
                )
            )", [$user[0]->id]); */
            $courses = Course::select('*')
                        ->whereIn('id',
                            Tier::select('course_id')
                            ->whereIn('id',
                                Sale::select('tier_id')
                                    ->where('user_id', '=', $user[0]['id'])
                            )
                )->get()->toArray();

            $active = 1;
        } else {
            //$courses = DB::select("SELECT * from courses where owner_id =". $user[0]->id);
            $courses = Course::select('*')
                        ->where('owner_id', '=', $user[0]['id'])->get()->toArray();
        }

        $aux_array = array();
        if (count($courses)){
            foreach ($courses as $course){
                //$price = DB::select("SELECT MIN(price) FROM tiers WHERE course_id=".$course->id);
                $price = Tier::select(DB::raw('MIN(price)'))
                            ->where('course_id', '=', $course['id'])->get()->toArray();
                $aux_array[$course['title']] = $price[0]['min']; 
             }
        }
        
        if (!$user) return redirect()->back()->with('status', 'Error');
        return view('profile', ['user'=>$user[0], 'courses' => $courses, 'prices' => $aux_array, 'active' => $active]);
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
            //DB::update('update users set firstname=?, lastname=?, description=? where id=?', [$request->firstname, $request->lastname, $request->about, Auth::user()->id]);
            User::find(Auth::user()->id)
                    ->update([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'description' => $request->about,
                    ]);
            return redirect(url("/profile/?username=" . Auth::user()->username));
        }
        $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg'
        ]);

        if (Storage::exists('public/images/' . Auth::user()->picture)) {
            Storage::delete('public/images/' . Auth::user()->picture);
        }

        $request->file('image')->store('public/images');
        //DB::update('update users set firstname=?, lastname=?, description=?, picture=? where id=?', [$request->firstname, $request->lastname, $request->about, $request->file('image')->hashName(), Auth::user()->id]);
        User::find(Auth::user()->id)
                    ->update([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'description' => $request->about,
                        'picture' => $request->file('image')->hashName(),
                    ]);
        return redirect(url("/profile/?username=" . Auth::user()->username));
    }
}