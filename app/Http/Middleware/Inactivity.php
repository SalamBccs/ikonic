<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Inactivity
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
        $user = Auth::user();
        if(Carbon::now()->diffInMinutes(Carbon::parse($user->activity_at)) < 15)
        {
            $user->update([
                'activity_at' => Carbon::now()
            ]);
            return $next($request);
        }
        else if($user->roles()->first()->name == 'student')
        {
            $user->update(['isLogin' => false]);
            DB::table('personal_access_tokens')->where('tokenable_id',$user->id)->delete();
            return response()->json([
                "success" => false,
                'message' => 'You must login first.'
            ], 401);
        }
        else{
            $user->update([
                'activity_at' => Carbon::now()
            ]);
            return $next($request);
        }
    }
}
