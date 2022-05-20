<?php

namespace App\Console\Commands;

use App\Models\auction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\image;
use App\Models\auction_bid;
use App\Models\User;

class checkIfAuctionTimeEnded extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:auctions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every minute checks if auctions ended or not. If ended it will make status changed';

    /**
     * Execute the console command.
     * php artisan schedule:work
     * @return int
     */
    public function handle()
    {
        $end = 'ended';

        $endedAuct = auction::where('end_date', '<=' ,Carbon::now('GMT+3'))
        ->where('status' , '!=' , $end)
        ->get();

        auction::where('end_date', '<=' ,Carbon::now('GMT+3'))
        ->where('status' , '!=' , $end)
        ->update([
            'status' => $end
        ]);

        foreach($endedAuct as $item)
        {        
            //Reikia:
            //Padaryti aukciona pasibaigusi+
            //Atimti suma is statytojo +
            //Prideti pinigus pardavejui +
            //Atnaujinti image oweneri +

            //Biggest bid at $bidInfo[0]
            $bidInfo = auction_bid::where('fk_auction_id', $item->id)
            ->orderBy('price', 'DESC')
            ->get();

            if(count($bidInfo) > 0)
            {
                $imageOwner = image::where('id', $item->fk_image_id)->get();

                User::where('id', $imageOwner[0]->fk_user_id_savininkas)
                ->increment('wallet_balance', $bidInfo[0]->price);
    
                User::where('id', $bidInfo[0]->fk_user_id)
                ->decrement('wallet_balance', $bidInfo[0]->price);
                
                //Update new owner of auction
                image::where('id', $item->fk_image_id)
                ->update([
                    'fk_user_id_savininkas' => $bidInfo[0]->fk_user_id
                ]);
            }
        }
        

        $this->info('Minute Update has been send successfully');
    }
}
