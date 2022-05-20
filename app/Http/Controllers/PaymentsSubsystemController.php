<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsSubsystemController extends Controller
{
    public function showPurchaseInformation($imageId, $userId, $action)
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
            'owner' => $user,
            'action' => $action,
            'userId' => $userId
            // 'bill' => $wasSold[0]
        ]);
    }

    public function purchaseWallet($imageId, $userId, $action)
    {
        $image = DB::table('images')->find($imageId);
        $collection =  DB::table('collections')->find($image->fk_collection_id_dabartine);
        $user =  DB::table('users')->find($image->fk_user_id_savininkas);
        return view ('PurchaseConfirmationWindow', [
            'image' => $image,
            'collection' => $collection,
            'owner' => $user,
            'action' => $action,
            'userId' => $userId
        ]);
    }

    public function purchaseBank($imageId, $userId, $action)
    {
        DB::update('UPDATE images SET fk_user_id_savininkas = ? WHERE id = ?',[
            $userId,
            $imageId
           ]);
        $image = DB::table('images')->find($imageId);
        $collection =  DB::table('collections')->find($image->fk_collection_id_dabartine);
        $user =  DB::table('users')->find($image->fk_user_id_savininkas);
        return view ('ImagePurchaseInformationView', [
            'image' => $image,
            'collection' => $collection,
            'owner' => $user,
            'action' => $action,
            'userId' => $userId
        ]);
    }

    public function purchaseConfirmation($imageId, $userId, $action)
    {

        $image = DB::table('images')->find($imageId);
        $collection =  DB::table('collections')->find($image->fk_collection_id_dabartine);
        $user =  DB::table('users')->find($image->fk_user_id_savininkas);

        if($user->wallet_balance >= $image->price)
        {
            $userBuyer =  DB::table('users')->find($userId);
            $price = $image->price;
            //pardavejui pridedam
            DB::update('UPDATE users SET wallet_balance = ? WHERE id = ?',[
                $user->wallet_balance + $price,
                $image->fk_user_id_savininkas

           ]);
           //pirkejui atimam
           DB::update('UPDATE users SET wallet_balance = ? WHERE id = ?',[
                $userBuyer->wallet_balance - $price,
                $userId
            ]);
            DB::update('UPDATE images SET fk_user_id_savininkas = ? WHERE id = ?',[
                $userId,
                $imageId
           ]);
            $action = 10;
            return view ('PurchaseConfirmationWindow', [
                'image' => $image,
                'collection' => $collection,
                'owner' => $user,
                'action' => $action,
                'userId' => $userId
            ]);
        }
        $action = 11;
        return view ('PurchaseConfirmationWindow', [
            'image' => $image,
            'collection' => $collection,
            'owner' => $user,
            'action' => $action,
            'userId' => $userId
        ]);
    }
}
