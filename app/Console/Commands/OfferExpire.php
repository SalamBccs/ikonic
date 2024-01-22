<?php

namespace App\Console\Commands;

use App\Models\MatchedOffers;
use App\Models\Operator;
use App\Models\User;
use App\Services\FirebaseService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class OfferExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offer:expire';

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
        $offers = MatchedOffers::with(['seller','buyer'])->where('status','!=','cancel')->where('status','!=','complete')->get();
        foreach($offers as $offer)
        {
            if(Carbon::now() >= Carbon::parse($offer->expire_time))
            {
                
                $ss = User::find($offer->seller_id);
                $ss->update([
                    'isBusy' => 0
                ]);
                if($ss->roles()->first()->name == 'Operator')
                {
                    Operator::where('operator_id',$ss->id)->first()->update([
                        'status' => 0
                    ]);
                }
                User::find($offer->buyer_id)->update([
                    'isBusy' => 0
                ]);
                $o = $offer;
                // $o['seller'] = User::find($o->seller_id)->only(['id','username']);
                // $o['buyer'] = User::find($o->buyer_id)->only(['id','username']);
                $fbservice = new FirebaseService();
                if($o->payment_sent == 1)
                {
                    $offer->update([
                        'report' => 1,
                        'expire_time' => '',
                    ]);
                    $fbservice->report_response($o);
                    Log::info('offer reported');

                }else{
                    $offer->update([
                        'status' => 'cancel'
                    ]);
                    $fbservice->cancel_response($o);
                    Log::info('offer expired');
                }
            }
        }
    }
}
