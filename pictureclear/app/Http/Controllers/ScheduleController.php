<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
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
        $this->middleware(['auth', 'verified', 'HasScheduleAccess', 'IsAdmin']);
    }

    public function checkSchedule(Request $request, $id){
        //$schedule = DB::select("SELECT * FROM schedules WHERE course_id = ?", [$id]);
        $schedule = Schedule::select('*')
                    ->where('course_id', '=', $id)->get()->toArray();
        $schedule_slots = ScheduleSlots::select('*')
            ->where('schedule_id', '=', $schedule[0]['id'])
            ->paginate(6);

        return view('schedule', ['schedule_slots'=>$schedule_slots, 'schedule' => $schedule[0]]);
    }

    public function makeAnAppointment(Request $request, $id, $slotId){
        //$schedule = DB::select("SELECT * FROM schedules WHERE id = ?", [$slotId]);
        //DB::update('update schedule_slots set isfree = FALSE, student_id = ? where id=?', [Auth::user()->id, $slotId]);
        ScheduleSlots::find($slotId)
                        ->update([
                            'isfree' => false,
                            'student_id' => Auth::user()->id,
                        ]);

        return back();
    }

    public function addHour(Request $request, $id){

        //$schedule = DB::select("SELECT * FROM schedules WHERE user_id = ? AND course_id = ?", [Auth::user()->id, $id]);
        $schedule = Schedule::select('*')
                    ->where('user_id', '=', Auth::user()->id)
                    ->where('course_id', '=', $id)->get()->toArray();
        $firstHour = date("d/m/Y H:i:s", strToTime($request['schedDia'].' '.$request['schedHoraInicial']));
        $lastHour = date("d/m/Y H:i:s", strToTime($request['schedDia'].' '.$request['schedHoraFinal']));
        
        $date1 = Carbon::createFromFormat('d/m/Y H:i:s', $firstHour);
        $date2 = Carbon::createFromFormat('d/m/Y H:i:s', $lastHour);

        if($date2->gt($date1)){
            ScheduleSlots::insert(array(
                'schedule_id' => $schedule[0]['id'],
                'isfree' => true,
                'begin' => $firstHour,
                'end' => $lastHour,
            ));
        } else {
            return back();
        }


        
        
        
        return back();
    }

    public function deleteSlot(Request $request, $id, $slotId){
        //$schedule = DB::select("SELECT * FROM schedules WHERE id = ?", [$slotId]);
        $slot = ScheduleSlots::where('id',$slotId)->delete();
        return back();
    }
}