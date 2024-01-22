<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Setting
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
        if($user && $user->roles()->first()->name != 'student')
        {
            return $next($request);
        }
        $setting = \App\Models\Setting::first();
        if (isset($setting) && $setting->application_status == 0) {

            $user = Auth::user();
            if ($user) {
                $user->update(['isLogin' => false]);
                DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
            }
            return response()->json([
                'success' => false,
                'message' => $setting->application_status_message,
            ],401);
        }
        return $next($request);
    }
}
