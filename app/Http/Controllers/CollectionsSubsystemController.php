<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\image;
use App\Models\collection;
use Illuminate\Http\Request;
use App\Models\image_for_sale;
use Illuminate\Support\Facades\DB;


class CollectionsSubsystemController extends Controller
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

    public function submitCollectionDelete($userId, $collectionId) {
        return redirect('CreatedCollectionsListView')->with([
            'openActionConfirmationForm' => true,
            'userId' => $userId,
            'itemID' => $collectionId
        ]);
    }

    //user id nereikia, bet meh...
    public function showCollectionInfo($userId, $collectionId)
    {
        $collection = DB::table('collections')->find($collectionId);
        $user = DB::table('users')->find($userId);
        return view('CollectionView')->with([
            'username' => $user->username,
            'collection' => $collection
        ]);
    }

    public function index(){
        // dd(request()->tag);
        return view('CollectionsListView', [
            'collections' => collection::latest()->filter(request(['search']))->paginate(20)
        ]);
    }

    public function openCollectionView(collection $collections) {
        // $imagesForSale = DB::table('images_for_sale')->select('id', 'fk_image_id')->get();
        
        $images = DB::table('images')->select('id', 'is_visible','title', 'image', 'rating', 'fk_collection_id_dabartine')
        ->where('is_visible','=', '1')
        ->where('fk_collection_id_dabartine',$collections->id)
        ->get();

        return view('CollectionViewInfo', [
            'collections' => $collections,
            'images' => $images
        ]);
    }

    private function sort($order = "DESC") {
        $collections = DB::select(
            "
                SELECT
                    collections.id as id,
                    collections.name as name,
                    collections.description as description,
                    collections.creation_date as creation_date
                FROM collections
                ORDER BY collections.creation_date ".$order
            );
        return $collections;
    }

    // sort images by price in descending order
    public function sortCollectionsListDesc() {
        $collections = $this->sort("DESC");
        return view('CollectionsListView', compact('collections'));
    }

    // sort images by price in ascending order
    public function sortCollectionsListAsc() {
        $collections = $this->sort("ASC");
        return view('CollectionsListView', compact('collections'));
    }
}
