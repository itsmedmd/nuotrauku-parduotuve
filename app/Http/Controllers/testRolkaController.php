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
            'collections' => $collections,
            'userId' => $userId,
            'collectionId' => null,
            'collectionName' => null,
            'collectionDescription' => null
            ]);
    }

    public function test()
    {
        dd('pasieke test controller');
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
