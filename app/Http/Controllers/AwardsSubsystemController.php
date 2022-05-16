<?php

namespace App\Http\Controllers;

use App\Models\award;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AwardsSubsystemController extends Controller
{
    private function index(){
        $awards = DB::select('
            SELECT
                awards.id as id,
                awards.date as date,
                awards.prize_amount as prize,
                images.image as img_url,
                images.title as title
            FROM awards
            INNER JOIN images
                ON awards.fk_image_id = images.id
        ');

        return $awards;
    }

    public function getAwards() {
        $awards = $this->index();
        return view('AwardsListView', compact('awards'));
    }
}
