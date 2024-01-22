<?php

namespace App\Console\Commands;

use App\Models\AmountTransfer;
use App\Models\ContactUs;
use App\Models\MatchedOffers;
use App\Models\Offers\Offers;
use App\Models\Operator;
use App\Models\orderBy;
use App\Models\User;
use App\Services\FirebaseService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete data 35 days old';

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
        $date = Carbon::now()->addDays(35);
        AmountTransfer::where('updated_at','>=',$date)->delete();
        orderBy::where('updated_at','>=',$date)->delete();
        $off = MatchedOffers::where('status','=','requested')->orWhere('status','=','accepted')->pluck('offer_id')->toArray();
        $offers = array_unique($off);
        Offers::whereNotIn('id',$offers)->where('updated_at','>=',$date)->delete();
        ContactUs::where('updated_at','>=',$date)->delete();
        Log::info('35 days old data deleted');
    }
}
