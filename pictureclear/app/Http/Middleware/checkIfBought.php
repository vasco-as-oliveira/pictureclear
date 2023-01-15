<?php

namespace App\Http\Middleware;

use App\Models\Course;
use App\Models\Sale;
use App\Models\Tier;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;





class checkIfBought
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
        $courseId = $request->id;
        //$subscribed_users = DB::select('select user_id from sales where tier_id IN(select id from tiers where course_id=' . $courseId . ') and user_id=' . Auth::User()->id . '');
        $arrayOfTiers = 
                        
        $subscribed_users = Sale::select('user_id')
                            ->whereIn('tier_id', 
                                Tier::select('id')
                                ->where('course_id', '=', $courseId)
                            )
                            ->where('user_id', '=', Auth::User()->id)->get()->toArray();
        //$courseBelongsToUser = DB::select('select owner_id from courses where id ='.$courseId);
        $courseBelongsToUser = Course::select('owner_id')
                                    ->where('id', '=', $courseId)->get()->toArray();
        if($subscribed_users || (Auth::User()->id == $courseBelongsToUser[0]['owner_id']) || (Auth::user()->is_admin)) {
            return $next($request);
        }
        return back();

    }
}
