<?php

namespace App\Http\Middleware;

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
        $subscribed_users = DB::select('select user_id from sales where tier_id IN(select id from tiers where course_id=' . $courseId . ') and user_id=' . Auth::User()->id . '');
        if(!$subscribed_users) {
            return redirect('/home');
        }
        return $next($request);
    }
}
