<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\auction;
use Carbon\Carbon;
use App\Models\image;
use App\Models\award;
use App\Models\bill;
use App\Models\auction_bid;
use App\Models\User;

class weeklyUpdate extends Command
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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('awards')->delete();
        
        $weekBills = DB::table('bills') 
            ->whereBetween('created_at', [
                now()->locale('en')->startOfWeek(),
                now()->locale('en')->endOfWeek(),
            ])
            ->get();

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
        // dd($weekBills);


        $pic_arr = array();
        if(count($weekBills)>0){
            for ($i = 0; $i < 3; $i++) {            
                $images = DB::table('images')
                ->where('id','=',$weekBills[$i]->fk_image_id)
                ->first();
                array_push($pic_arr, $images);
            }
        }
        // dd($pic_arr);

        $reward = [1000,500,250];
        if(count($pic_arr) > 0)
        {
            for ($i = 0; $i < 3; $i++) {         
                $imageOwner = image::where('id', $weekBills[$i]->fk_image_id)->get();
                User::where('id', $imageOwner[0]->fk_user_id_savininkas)
                ->increment('wallet_balance', $reward[$i]);
                // $pls = 
                $pls = DB::table('awards')->insert(
                    [
                        'prize_amount' => $reward[$i],
                        'fk_user_id_laimetojas' => $imageOwner[0]->fk_user_id_savininkas,
                        'fk_image_id' => $weekBills[$i]->fk_image_id
                    ]
                );
                // $pls->join('images', 'fk_image_id', '=' ,'images.id')
                // ->first();
            }
        }
        
        $this->info('Week Update has been send successfully');
    }
}
