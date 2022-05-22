<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\bill;
use App\Models\User;
use App\Models\award;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AwardsSubsystemController extends Controller
{
    // wait tai cia ne bills limit 3 reikia
    // cia jau final 3 awards
    // nu tipo algoritmas:
    // paimi visus egzistuojancius bills irasus
    // suskaiciuoji kiek per praeitas 7 dienas (pagal data atrenki) kiekviena nuotrauka turi bills
    // tuos counts surikiuoji mazejancia tvarka, tai pvz turiu 6 nuotraukas ir bills count bus: [70, 15, 12, 7, 6, 0]
    // tada top 3 atrenki, tai [70, 15, 12]
    // va cia laimejusios nuotraukos, tada sukuri awards irasus joms ir apdovanoji kurejus

    private function index(){        
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
                DB::table('awards')->insert(
                    [
                        'prize_amount' => $reward[$i],
                        'fk_user_id_laimetojas' => $imageOwner[0]->fk_user_id_savininkas,
                        'fk_image_id' => $weekBills[$i]->fk_image_id
                    ]
                );
            }
        }
        // dd($pls);
        
        return $pic_arr; 
    }

    public function getAwards() {
        // $awards = $this->index();
        $awards = DB::table('awards')
        ->join('images', 'fk_image_id', '=' ,'images.id')
        ->get();
        // dd($awards);
        return view('AwardsListView', compact('awards'));
    }
}
