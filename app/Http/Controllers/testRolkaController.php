<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class testRolkaController extends Controller
{
    public function openCreatedCollectionsListView($id)
    {
        $collections = DB::table('collections')
        ->where('fk_user_id_kurejas', $id)
        ->get();
        $sk = 7;
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

    public function createNewCollection($userId, $collectionName, $description)
    {   
        DB::insert('INSERT INTO collections (name, description, fk_user_id_kurejas)
                    VALUES(?, ?, ?)', [
                        $collectionName, $description, $userId
        ]);
        $collections = DB::table('collections')
        ->where('fk_user_id_kurejas', $userId)
        ->get();
        return view('CreatedCollectionsListView', [
            'collections' => $collections,
            'userId' => $userId,
            'collectionId' => null,
            'collectionName' => $collectionName,
            'collectionDescription' => $description           
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

    public function editCollection($collectionId, $collectionName, $description)
    {
        return dd('inEditCollection');
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
