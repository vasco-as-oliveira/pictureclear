<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ScheduleSlots;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Course;
use Illuminate\Support\Facades\Storage;


class ScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'HasScheduleAccess']);
    }

    public function checkSchedule(Request $request, $id){
        $schedule = DB::select("SELECT * FROM schedules WHERE course_id = ?", [$id]);
        $schedule_slots = DB::table('schedule_slots')
            ->where('schedule_id', '=', $schedule[0]->id)
            ->paginate(6);
        //$schedule_slots = DB::select("SELECT * FROM schedule_slots WHERE schedule_id = ?", [$schedule[0]->id])->paginate(1);

        return view('schedule', ['schedule_slots'=>$schedule_slots, 'schedule' => $schedule[0]]);
    }

    public function makeAnAppointment(Request $request, $id, $slotId){
        $schedule = DB::select("SELECT * FROM schedules WHERE id = ?", [$slotId]);
        
        DB::update('update schedule_slots set isfree = FALSE where id=?', [$slotId]);
        return back();
    }

    public function addHour(Request $request, $id){

        $schedule = DB::select("SELECT * FROM schedules WHERE user_id = ? AND course_id = ?", [Auth::user()->id, $id]);
        $firstHour = date("d/m/Y H:i:s", strToTime($request['schedDia'].' '.$request['schedHoraInicial']));
        $lastHour = date("d/m/Y H:i:s", strToTime($request['schedDia'].' '.$request['schedHoraFinal']));

        ScheduleSlots::insert(array(
            'schedule_id' => $schedule[0]->id,
            'isfree' => true,
            'begin' => $firstHour,
            'end' => $lastHour,
        ));
        
        
        return back();
    }
}