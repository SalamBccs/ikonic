<?php

namespace App\Console\Commands;

use App\Models\MatchedOffers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AlreadyTrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'already:trade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Already in Trade';

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
        $b = \App\Models\MatchedOffers::where('status','!=','cancel')->where('status','!=','complete')->pluck('buyer_id')->toArray();
        $s = \App\Models\MatchedOffers::where('status','!=','cancel')->where('status','!=','complete')->pluck('seller_id')->toArray();
        $u = array_merge($b,$s);
        $users = array_unique($u);
        \App\Models\User::whereNotIn('id',$users)->update([
            'isBusy' => 0
        ]);
        Log::info('already trade users removed buyer => '.implode($b).' seller => '.implode($s).' all => '.implode($u).' unique => '.implode($users));
    }
}
