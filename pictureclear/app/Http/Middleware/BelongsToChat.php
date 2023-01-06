<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;





class BelongsToChat
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
        $chatId = $request->id;
        $chat = DB::select("SELECT * FROM chats WHERE id = ".$chatId);
        if($chat){
            if($chat[0]->teacher_id == Auth::user()->id || $chat[0]->student_id == Auth::user()->id) {
                return $next($request);
            }
        }
        return redirect('home');

    }
}
