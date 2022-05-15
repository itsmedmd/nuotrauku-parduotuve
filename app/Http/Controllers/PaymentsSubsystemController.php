<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsSubsystemController extends Controller
{
    public function showPurchaseInformation($imageId, $userId)
    {
        $image = DB::table('images')->find($imageId);
        $collection =  DB::table('collections')->find($image->fk_collection_id_dabartine);
        $user =  DB::table('users')->find($image->fk_user_id_savininkas);
        // $wasSold = DB::table('bills')
        // ->where('fk_image_id', $imageId)
        // ->get();
        return view ('ImagePurchaseInformationView', [
            'image' => $image,
            'collection' => $collection,
            'owner' => $user
            // 'bill' => $wasSold[0]
        ]);
    }
}
