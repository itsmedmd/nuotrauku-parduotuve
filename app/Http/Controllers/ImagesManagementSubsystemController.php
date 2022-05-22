<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\image_for_sale;
use App\Models\comment;
use App\Models\bill;
use App\Models\image_rating;
use App\Models\collection;
use App\Models\auction;
use App\Models\auction_bid;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\DB;

class ImagesManagementSubsystemController extends Controller
{
    private $USER_ID = 1;

    // validate new image data
    private function validateNewImageData(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|max:200',
            'image' => 'required|image',
            'description' => 'max:500',
            'price' => 'required|min:0',
            'collection_id' => 'required'
        ]);
    }

    // validate image information edit data
    private function validateImageData(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|max:200',
            'description' => 'max:500',
            'price' => 'required|min:0'
        ]);
    }

    // open image creation view with collections list to select from
    public function openImageCreationView() {
        $collections = collection::where('fk_user_id_kurejas', $this->USER_ID)->get();
        return view('ImageCreationView', compact('collections'));
    }

    // create new image
    public function submitNewImageCreation(Request $request)
    {
        $this->validateNewImageData($request);
 
        // save the image file in storage/public/images
        $path = $request->file('image')->store('public/images');
        $path_arr = explode("/", $path); 

        // create new image entry in the database
        $img = new image;
        
        $img->title = $request->title;
        $img->description = $request->description;
        $img->rating = 0;
        $img->price = $request->price;
        $img->is_visible = true;
        $img->fk_collection_id_dabartine = $request->collection_id;
        $img->fk_collection_id_originali = $request->collection_id;
        $img->fk_user_id_savininkas = $this->USER_ID;
        $img->fk_user_id_kurejas = $this->USER_ID;
        
        // create file path in format: "storage/images/{filename}"
        $img->image = 'storage/'.$path_arr[1].'/'.$path_arr[2];

        $img->save();

        // --- THIS WORKS CORRECTLY, IT JUST NEEDS TO BE A SEPARATE FUNCTION FOR "PA19" USE CASE:
        // create image_for_sale for this image
        // $img_id = $img->id; // get id of created image entry
        // $img_for_sale = new image_for_sale;
        // $img_for_sale->price = $request->price;
        // $img_for_sale->fk_image_id = $img_id;
        // $img_for_sale->save();
        
        return redirect('CreatedImagesListView')->with('success-status', 'New image successfully created!');
    }

    // open created images list
    public function displayCreatedImageList() {
        $images = image::where('fk_user_id_kurejas', $this->USER_ID)->orderBy('creation_date', 'desc')->get();
        return view('CreatedImagesListView', compact('images'));
    }

    // open delete image view
    public function submitImageDelete($id) {
        return redirect('CreatedImagesListView')->with([
            'openActionConfirmationForm' => true,
            'itemID' => $id
        ]);
    }

    // delete image
    public function deleteImage($id) {
        # get image for sale
        $image_for_sale = image_for_sale::where('id', $id)->get();

        # delete comments
        comment::where('fk_image_for_sale_id', $image_for_sale[0]->id)->delete();

        # delete image bills
        bill::where('fk_image_id', $id)->delete();

        # delete image ratings
        image_rating::where('fk_image_id', $id)->delete();

        # get image
        $img = image::findOrFail($image_for_sale[0]->fk_image_id);

        # delete image for sale
        image_for_sale::where('id', $id)->delete();

        # get image auction
        $auction = auction::where('fk_image_id', $img->id)->get();

        # delete auction and auction bids
        if (count($auction) > 0) {
            auction_bid::where('fk_auction_id', $auction[0]->id)->delete();
            auction::where('fk_image_id', $img->id)->delete();
        }

        // delete image file from storage 
        $path_arr = explode("/", $img->image); 
        $path_in_storage = 'public/'.$path_arr[1].'/'.$path_arr[2];
        Storage::delete($path_in_storage);

        // delete image frim the database
        $img->delete();

        return redirect('CreatedImagesListView')->with('success-status', 'Image successfully deleted!');
    }

    // open edit information view with selected image information
    public function editImageInformation($id) {
        $img = image::findOrFail($id);
        return view('ImageInformationEditView')->with('image', $img);
    }

    // edit information
    public function submitNewImageData(Request $request) {
        $this->validateImageData($request);

        image::whereId($request->id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect('CreatedImagesListView')->with('success-status', 'Successfully updated image information!');
    }

    public function openOwnedImageInformationView($id)
    {
        $image = DB::table('images')->find($id);   //vienam
        //return view('OwnedImageInformationView')->with('image', $image);

        // $sk = $image->title;   
        return view('OwnedImageInformationView', [
            'image' => $image,
        ]);
    }

    public function changeVisibility($id)
    {
        $image = DB::table('images')->find($id);   //vienam
        Debugbar::info($image->is_visible);
        if($image->is_visible == 0)
        {
            Debugbar::info('ieita i iF');
            $image = DB::update('UPDATE images set is_visible = ? where id = ?', [
                1, $id
            ]);
        }
        else
        {
            Debugbar::info('ieita i iF else');
            $image = DB::update('UPDATE images set is_visible = ? where id = ?', [
                0, $id
            ]); 
        }
        $image = DB::table('images')->find($id);   //vienam

        return view('OwnedImageInformationView', [
            'image' => $image,
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
}
