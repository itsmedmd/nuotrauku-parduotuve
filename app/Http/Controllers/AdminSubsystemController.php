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

class AdminSubsystemController extends Controller
{
    public function submitImageDelete($id) {
        return redirect('imageInformationView/'.$id)->with([
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

        return redirect('ImagesListView')->with('success-status', 'Image successfully deleted!');
    }
}
