<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VideoListController extends Controller
{
    public function index(Request $request, $id) {
        //$result = DB::select('select * from lessons Where course_id ='.$id);
        $result = Lesson:: select('*')
                        ->where('course_id', '=', $id)->get()->toArray();
        return view('videos', ['result'=>$result]);
    }

    public function watchvideo(Request $request, $courseId, $videoid){
        //$result = DB::select('select * from lessons Where id ='.$videoid);
        $result = Lesson::select('*')
                        ->where('id', '=', $videoid)->get()->toArray();
        return view('player', ['lesson' => $result[0]]);
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'checkIfBought']);
    }
}
