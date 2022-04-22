<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\image_for_sale;

class ImagesSubsystemController extends Controller
{
    // public function TESTdoSomething()
    // {
    //     // returns json data
    //     return response()->json(
    //         [
    //             'status'=> 'error',
    //             'message'=> 'oof'
    //         ]
    //     );
    // }

    // gets all images for sale with their information
    public function getImagesForSale() {
        $images = DB::select('
            SELECT
                images.title as title,
                images.image as img_url,
                collections.name as collection,
                images_for_sale.price as price,
                images.description as img_description
            FROM images_for_sale
            INNER JOIN images
                ON images_for_sale.fk_image_id = images.id
            INNER JOIN collections
                ON images.fk_collection_id_dabartine = collections.id
            WHERE images.is_visible = 1
        ');

        return view('ImagesListView', compact('images'));
    }

    // search images for sale for their title/description/collection
    public function submitImageSearch(Request $request) {
        $images = DB::select(
        "
            SELECT
                images.title as title,
                images.image as img_url,
                collections.name as collection,
                images_for_sale.price as price,
                images.description as img_description
            FROM images_for_sale
            INNER JOIN images
                ON images_for_sale.fk_image_id = images.id
            INNER JOIN collections
                ON images.fk_collection_id_dabartine = collections.id
            WHERE
                images.is_visible = 1
                AND
                (
                    images.title LIKE '%".$request->text."%'
                    OR images.description LIKE '%".$request->text."%'
                    OR collections.name LIKE '%".$request->text."%'
                )
        ");

        return view('ImagesListView', compact('images'));
    }
}
