<?php

namespace App\Http\Controllers;

use App\Models\award;
use App\Models\Image;
use App\Models\bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

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

        $weekBills = DB::table('bills') 
            ->whereBetween('created_at', [
                now()->locale('en')->startOfWeek(),
                now()->locale('en')->endOfWeek(),
            ])
            ->get();

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
        // dd($weekBills);


        $pic_arr = array();
        for ($i = 0; $i < 3; $i++) {            
            $images = DB::table('images')
            ->where('id','=',$weekBills[$i]->fk_image_id)
            ->first();
            array_push($pic_arr, $images);
        }
        // dd($pic_arr);

        
        return $pic_arr; 
    }

    public function getAwards() {
        $awards = $this->index();
        // dd($awards);
        return view('AwardsListView', compact('awards'));
    }
}
