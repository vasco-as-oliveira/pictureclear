<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;





class HasScheduleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $course_id = $request->id;
        $schedule = DB::select("SELECT * FROM schedules WHERE course_id = ?", [$course_id]);
        $courseOwner = DB::select("SELECT * from courses WHERE id = ? AND owner_id = ?",[$schedule[0]->course_id, Auth::user()->id]);
        if($courseOwner) return $next($request);
        if($schedule){
            $belongsToCourse = DB::select("SELECT * FROM tiers WHERE hasscheduleperk = true AND id IN(SELECT tier_id FROM sales WHERE user_id = ?)", [Auth::user()->id]);
            if($belongsToCourse) return $next($request);
        }
        
        return redirect('home');

    }
}
