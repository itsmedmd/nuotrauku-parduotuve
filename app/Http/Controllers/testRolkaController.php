<?php
// Debug bar usage
// Debugbar::info('stringHere');
// Debugbar::error('stringHere');
// Debugbar::warning('stringHere');
// Debugbar::addMessage('stringHere');

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class testRolkaController extends Controller
{
    public function openCreatedCollectionsListView($id)
    {
        $collections = DB::table('collections')
        ->where('fk_user_id_kurejas', $id)
        ->get();
        $userId = $id;
        return view('CreatedCollectionsListView', [
            'collections' => $collections,
            'userId' => $id,
            'collectionId' => null,
            'collectionName' => null,
            'collectionDescription' => null
            ]);
    }

    public function openCollectionCreationView($id)
    {
         $collections = DB::table('collections')
            ->where('id', $id)
            ->get();
            return view('CollectionCreationView', [
                'collections' => $collections,
                'userId' => $id,
                'collectionId' => null,
                'collectionName' => null,
                'collectionDescription' => null          
                ]);
    }

    public function deleteCollection($userId, $collectionId)
    {   
        DB::delete('DELETE FROM collections
                    WHERE id = ?', [$collectionId]);
        $collections = DB::table('collections')
            ->where('fk_user_id_kurejas', $userId)
            ->get();
        return view('CreatedCollectionsListView', [
            'collections' => $collections,
            'userId' => $userId,
            'collectionId' => $collectionId,
            'collectionName' => null,
            'collectionDescription' => null             
        ]);
    }

    public function createCollection(Request $request, $userId)
    {
        //Debugbar::addMessage($request->input('collectionName'));
        DB::insert('INSERT INTO collections (name, description, fk_user_id_kurejas)
                    VALUES(?, ?, ?)', [
                $request->input('collectionName'),
                $request->input('description'),
                $userId
            ]);
        $request->request->remove('collectionName');    //neremovina laiku...
        $request->request->remove('description');
        $collections = DB::table('collections')
        ->where('fk_user_id_kurejas', $userId)
        ->get();
        return view('CreatedCollectionsListView', [
            'collections' => $collections,
            'userId' => $userId,
            'collectionId' => null,
            'collectionName' => null,
            'collectionDescription' => null
            ]);
    }

    public function openEditCollectionView($userId, $collectionId, $collectionName, $collectionDescription)
    {
        //Debugbar::addMessage($request->input('collectionName'));

        $collections = DB::table('collections')
        ->where('fk_user_id_kurejas', $userId)
        ->get();
        return view('CollectionEditView', [
            'collections' => $collections,
            'userId' => $userId,
            'collectionId' => $collectionId,
            'collectionName' => $collectionName,
            'collectionDescription' => $collectionDescription
            ]);
    }

    public function editCollection(Request $request, $userId, $collectionId)
    {
        
        Debugbar::addMessage($userId);
        Debugbar::addMessage($collectionId);
        Debugbar::addMessage($request->input('collectionName'));
        Debugbar::addMessage($request->input('description'));
        DB::update('UPDATE collections SET name = ?, description = ? WHERE id = ?',[
                     $request->input('collectionName'),
                     $request->input('description'),
                     $collectionId
                    ]);
        $collections = DB::table('collections')
        ->where('fk_user_id_kurejas', $userId)
        ->get();
        return view('CreatedCollectionsListView', [
            
            'userId' => $userId,
            'collectionId' => null,
            'collectionName' => null,
            'collectionDescription' => null
            ]);
    }
    public function openOwnedImages($userId)
    {   
        $images = DB::table('images')
            ->where('fk_user_id_savininkas', $userId)
            ->get();
        $collections = DB::table('collections')
            ->where('fk_user_id_kurejas', $userId)
            ->get();
        return view('OwnedImagesListView', [
            'images' => $images,
            'userId' => $userId,
            'collections' => $collections,
            'msg' => null
            ]);
    }

    public function movePictureToCollection(Request $request, $userId,)
    {   
        DB::update('UPDATE images SET fk_collection_id_dabartine = ? WHERE id = ?',[
            $request->input('collId'),
            $request->input('picId')
           ]);
        $images = DB::table('images')
           ->where('fk_user_id_savininkas', $userId)
           ->get();
       $collections = DB::table('collections')
           ->where('fk_user_id_kurejas', $userId)
           ->get();
       return view('OwnedImagesListView', [
           'images' => $images,
           'userId' => $userId,
           'collections' => $collections,
           'msg' => "Successfully moved" 
           ]);
    }

    public function openSellPictureWindow($userId, $pictureId)
    {   
        return view ('ImageForSaleCreationView', [
            'pictureId' => $pictureId,
            'userId' => $userId,
            'msg' => null
        ]);
    }

    public function putForSale(Request $request, $userId, $pictureId)
    {           
        $image = DB::table('images')->find($pictureId);
        $forSale = DB::table('images_for_sale')
          ->where('fk_image_id', $pictureId)
          ->get();
        $exists = sizeof($forSale);
        
        if($exists == 1){
            $picture = $forSale[0];
        DB::update('UPDATE images_for_sale SET price = ?, updated_at = CURRENT_TIMESTAMP() WHERE id = ?',[
            $request->input('price'),
            $picture->id
           ]);
        }
        else{
            DB::insert('INSERT INTO images_for_sale (price, creation_date, fk_image_id, created_at)
            VALUES(?, ?, ?, CURRENT_TIMESTAMP())', [  
            $request->input('price'),
            $image->creation_date,
            $pictureId
        ]);
        }
        $msg = "";
        if($exists == 1)
            $msg = " price updated.";
        else $msg = " placed for sale";

        return view ('ImageForSaleCreationView', [
            'pictureId' => $pictureId,
            'userId' => $userId,
            'msg' => $image->title.$msg
        ]);
    }

    public function showPurchaseInformation($imageId)
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
            'user' => $user
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

    public function test()
    {
        return "Pasieke testController.test()";
    }

    // public function openOwnedImageInformationView($id)
    // {
    //     $image = DB::table('images')->find($id);   //vienam
    //     //return view('OwnedImageInformationView')->with('image', $image);

    //     // $sk = $image->title;   
    //     return view('OwnedImageInformationView', [
    //         'image' => $image,
    //     ]);
    // }

    // public function notShow($id)
    // {
    //     $image = DB::table('images')->find($id);   //vienam
    //     return view('OwnedImageInformationView')->with('image', $image);

    //     // $sk = 0;
    //     // $sk = $image->title;   
    //     // return view('OwnedImageInformationView', [
    //     //     'image' => $image,
    //     //     'sk' => $sk
    //     // ]);
    // }

    // public function changeVisibility($id)
    // {
    //     // dd('in CHANGE VISIBILITY');
    //     $image = DB::table('images')->find($id);   //vienam
    //     Debugbar::info($image->is_visible);
    //     if($image->is_visible == 0)
    //     {
    //         Debugbar::info('ieita i iF');
    //         $image = DB::update('UPDATE images set is_visible = ? where id = ?', [
    //             1, 1
    //         ]);
    //     }
    //     else
    //     {
    //         Debugbar::info('ieita i iF else');
    //         $image = DB::update('UPDATE images set is_visible = ? where id = ?', [
    //             0, 1
    //         ]); 
    //     }
    //     $image = DB::table('images')->find($id);   //vienam

    //     return view('OwnedImageInformationView', [
    //         'image' => $image,
    //     ]);


    //     //return view('OwnedImageInformationView')->with('image', $image);
    //     // $image = DB::table('images')->find($id);   //vienam

    //     // $image = DB::table('images')->update()



    //     // return view('OwnedImageInformationView')->with('image', $image);
    // }
}
