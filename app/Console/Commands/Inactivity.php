<?php

namespace App\Console\Commands;

use App\Models\MatchedOffers;
use App\Models\Operator;
use App\Models\User;
use App\Services\FirebaseService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Inactivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'active:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Offer Expire';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(\App\Models\User::role('student')->where('isLogin',1)->where('isBusy',0)->get() as $user)
        {
        if(Carbon::now()->diffInMinutes(Carbon::parse($user->activity_at)) > 15 && $user->isBusy == 0)
        {
            $user->update(['isLogin' => false]);
            \DB::table('personal_access_tokens')->where('tokenable_id',$user->id)->delete();
            $fbservice = new \App\Services\FirebaseService();
            $fbservice->user_session($user);
            Log::info('user session expired');
        }

        }
    }
}
