<?php

namespace App\Console\Commands;

use App\Models\BlockedUser;
use App\Models\MatchedOffers;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BlockedOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocked:offers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Blocked offer';

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
        // 2023-01-10 06:39:50 >= 2023-01-10 13:47:50
        $offers = BlockedUser::all();
        foreach ($offers as $key => $offer) {
            if(Carbon::now()->diffInHours(Carbon::parse($offer->created_at)) >= 3)
            {
                $offer->delete();
            }
        }
        Log::info('blocked offers removed ');
    }
}
