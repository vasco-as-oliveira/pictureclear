<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VideoListController extends Controller
{
    public function index(Request $request, $id) {
        $result = DB::select('select * from lessons Where course_id ='.$id);
        return view('videos', ['result'=>$result]);
    }

    public function watchvideo(Request $request, $id){
        $result = DB::select('select * from lessons Where id ='.$id);
        return view('player', ['lesson' => $result[0]]);
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

}
