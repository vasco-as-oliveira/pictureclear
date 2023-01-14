<?php

namespace App\Http\Controllers\CourseCreation;

use App\Models\Course;
use App\Models\CourseRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Chats;
use App\Models\Lesson;
use App\Models\Sale;
use App\Models\Schedule;
use App\Models\Tier;
use App\Models\User;
use Illuminate\Support\Facades\DB;




class CheckCourseFormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function viewCourse(Request $request) {
        
        $user = null;
        $find = $request['selectCourse'];
        //$course = DB::select('select * from courses where id = '.$find.'');
        $course = Course::select('*')
                        ->where('id', '=', $find)->get()->toArray();
        if($course){
            //$user = DB::select('select * from users where id = '.$course[0]->owner_id.'');
            $user = User::select('*')
                        ->where('id', '=', $course[0]['owner_id'])->get()->toArray();
            //$rating = DB::select('select * from course_ratings where user_id=? and course_id =? ', [Auth::id(), $course[0]->id]);
            $rating = CourseRating::select('*')
                        ->where('user_id', '=', Auth::id())
                        ->where('course_id', '=', $course[0]['id'])->get()->toArray();
            //$lessons = DB::select('select * from lessons where course_id = ?', [$course[0]->id]);
            $lessons = Lesson::select('*')
                        ->where('course_id', '=', $course[0]['id'])->get()->toArray();
            //$subscribed_users = DB::select('select user_id from sales where tier_id IN(select id from tiers where course_id=' . $course[0]->id . ') and user_id=' . Auth::user()->id . '');
            $arrayOfTiers = Tier::select('id')
                        ->where('course_id', '=', $course[0]['id'])
                        ->where('user_id', '=', Auth::User()->id);
            $subscribed_users = Sale::whereIn('tier_id', $arrayOfTiers)->get()->toArray();
            //$ratesCount = DB::select('select count(*) as contagem from course_ratings where course_id = ?', [$course[0]->id]);
            $ratesCount = CourseRating::select(DB::raw('count(*) as contagem'))
                        ->where('course_id', '=', $course[0]['id'])->get()->toArray();
            //$chat = DB::select('select * from chats where teacher_id = ? AND student_id = ?', [$course[0]->owner_id, Auth::user()->id ]);
            $chat = Chats::select('*')
                        ->where('teacher_id', '=', $course[0]['owner_id'])
                        ->where('student_id', '=', Auth::user()->id)->get()->toArray();
            //$chatTeacher = DB::select('select * from chats where teacher_id = ?', [Auth::user()->id]);
            $chatTeacher = Chats::select('*')
                        ->where('teacher_id', '=', Auth::user()->id)->get()->toArray();
            //$schedule = DB::select('select * from schedules where user_id = ? AND course_id = ?', [$course[0]->owner_id, $course[0]->id]);
            $schedule = Schedule::select('*')
                        ->where('user_id', '=', $course[0]['owner_id'])
                        ->where('course_id', '=', $course[0]['id'])->get()->toArray();
            if(!$chat) $chat[0] = 0;
            if(!$chatTeacher) $chatTeacher[0] = 0;
            if(!$schedule) $schedule[0] = 0;

            if($course[0]['owner_id'] == Auth::id()){
                return view('coursePageOwner', [
                    'checkCourse' => $course[0],
                     'checkUser' => $user[0], 
                     'checkRating' => $rating,
                     'checkLesson' => $lessons,
                     'checkSubbedUsers' => $subscribed_users,
                     'checkRatesCount'=> $ratesCount,
                     'chat' => $chatTeacher[0],
                     'schedule' => $schedule[0],
                    ]);
            } else if($course[0]->public) {
                return view('checkCourse', [
                    'checkCourse' => $course[0],
                    'checkUser' => $user[0],
                    'checkRating' => $rating,
                    'checkLesson' => $lessons,
                    'checkSubbedUsers' => $subscribed_users,
                    'checkRatesCount'=> $ratesCount,
                    'chat' => $chat[0],
                    'schedule' => $schedule[0],
                    ]);
            }
        }
        return redirect('/home');
    }

    public function finishSetup(Request $request, $id)
    {
      

        if(!empty($request->input('description'))){
            $request->validate([
                'description' => ['string', 'max:150'],
            ]);
            //DB::update("update courses set description=? where id=?", [$request->description, $id]);

            Course::find($id)
                    ->update([
                        'description' => $request->description
                    ]);
        }

        if($request->file('inputImage') != null){
            $request->validate([
                'inputImage' => ['image','mimes:png,jpg,jpeg'],
            ]);
            $request->file('inputImage')->store('public/images');
            //DB::update("update courses set image =? where id=?", [$request->file('inputImage')->hashName(), $id]);
            Course::find($id)
                    ->update([
                        'image' => $request->file('inputImage')->hashName()
                    ]);
        }
        return back();
    }

    public function publishRating (Request $request, $id)
    {
        //$rating = $request->input('rate');

        //$request->validate(['rating'=>'required|integer|between:1,5']);
        //return redirect("https://youtu.be/-GGixCs0290");
        
        CourseRating::insert([
            ['user_id' => Auth::user()->id,
            'course_id' => $id,
            'rating' => $request->input('rating')]
        ]);
        
        //$getCourse = DB::select('select * from courses where id = ?', [$id]);
        $getCourse = Course::select('*')
                        ->where('id', '=', $id)->get()->toArray();
        //$selAvgCourseRating = DB::select('select AVG(rating) as media from course_ratings where course_id = ?', [$id]);
        $selAvgCourseRating = CourseRating::select('AVG(rating) as media')
                                ->where('course_id', '=', $id)->get()->toArray();
        //DB::update('update courses set rating = ? where id = ?', [$selAvgCourseRating[0]['media'], $id]);
        Course::find($id)
                ->update([
                    'rating' => $selAvgCourseRating[0]['media']
                ]);
        //$selAvgUserRating = DB::select('select AVG(rating) as media from course_ratings where course_id IN (select id from courses where owner_id= ? )', [$getCourse[0]->owner_id]);
        $selAvgUserRating = CourseRating::select('AVG(rating) as media')
                                ->whereIn('course_id',
                                    Course::select('id')
                                        ->where('owner_id', '=', $getCourse[0]['owner_id'])
                                )->get()->toArray();
        //DB::update('update users set rating = ? where id = ?', [$selAvgUserRating[0]['media'], $getCourse[0]['owner_id']]);
        User::find($getCourse[0]['owner_id'])
                ->update([
                    'rating' => $selAvgUserRating[0]['media']
                ]);
        return back();
    }
    public function launchCourse(Request $request, $id)
    {
        //DB::update("update courses set public = NOT public where id=?", [$id]);
        Course::find($id)
                ->update([
                    'public' => true
                ]);
        return back();
    }
}
