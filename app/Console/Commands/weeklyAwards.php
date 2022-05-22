<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use App\Models\auction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\image;
use App\Models\award;
use App\Models\bill;
use App\Models\auction_bid;
use App\Models\User;

class checkIfAuctionTimeEnded extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:awards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every week create new awards';

    /**
     * Execute the console command.
     * php artisan schedule:work
     * @return int
     */
    public function handle()
    {
        $generateNewAwards = 'generated';

        $genAwards = auction::where('end_date', '<=' ,Carbon::getWeekEndsAt())
        ->where('status' , '!=' , $generateNewAwards)
        ->get();

        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

        auction::where('end_date', '<=' , $weekEndDate)
        ->where('status' , '!=' , $generateNewAwards)
        ->update([
            'status' => $generateNewAwards
        ]);

        foreach($genAwards as $item)
        {        
            //Reikia:
            //Padaryti aukciona pasibaigusi+
            //Atimti suma is statytojo +
            //Prideti pinigus pardavejui +
            //Atnaujinti image oweneri +

            //Biggest bid at $bidInfo[0]

            $weekBills = DB::table('bills')->get();

            // dump($weekBills);

            $weekBills = DB::select("
                SELECT
                    fk_image_id,
                    COUNT(*)
                FROM 
                    bills
                GROUP BY
                    fk_image_id
                ORDER BY
                    COUNT(*) DESC  
                LIMIT 3
            ");
            
            $bidInfo = auction_bid::where('fk_auction_id', $item->id)
            ->orderBy('price', 'DESC')
            ->get();
        
            $reward = [1000,500,250];
            for ($i = 0; $i < 3; $i++) {            
                
                if(count($weekBills) > 0)
                {
                    $imageOwner = image::where('id', $item->fk_image_id)->get();

                    User::where('id', $imageOwner[0]->fk_user_id_savininkas)
                    ->increment('wallet_balance', $reward[$i]);
        
                    // User::where('id', $bidInfo[0]->fk_user_id)
                    // ->decrement('wallet_balance', $bidInfo[0]->price);
                    
                    //Update new owner of auction
                    // image::where('id', $item->fk_image_id)
                    // ->update([
                    //     'fk_user_id_savininkas' => $bidInfo[0]->fk_user_id
                    // ]);
               }   

            }
            
        }
        

        $this->info('Week Update has been send successfully');
    }
}