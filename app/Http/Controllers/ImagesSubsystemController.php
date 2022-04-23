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
    private function getAllImagesForSale () {
        $images = DB::select('
            SELECT
                images.id as id,
                images.title as title,
                images.rating as rating,
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
            ORDER BY images.creation_date DESC
        ');

        return $images;
    }

    // gets all images that match search input
    private function getSearchResults($text, $order = "DESC") {
        $images = DB::select(
            "
                SELECT
                    images.id as id,
                    images.rating as rating,
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
                        images.title LIKE '%".$text."%'
                        OR images.description LIKE '%".$text."%'
                        OR collections.name LIKE '%".$text."%'
                    )
                ORDER BY images_for_sale.price ".$order
            );

        return $images;
    }

    // return view with all images
    public function getImagesForSale() {
        $images = $this->getAllImagesForSale();
        return view('ImagesListView', compact('images'));
    }

    // return view with search results
    public function submitImageSearch(Request $request) {
        $images = $this->getSearchResults($request->text);
        return view('ImagesListView', compact('images'));
    }

    // sort images by price in descending order
    public function sortImageListDesc(Request $request) {
        $images = $this->getSearchResults($request->text, "DESC");

        return view('ImagesListView', compact('images'));
    }

    // sort images by price in ascending order
    public function sortImageListAsc(Request $request) {
        $images = $this->getSearchResults($request->text, "ASC");

        return view('ImagesListView', compact('images'));
    }

    // open image information view with the image data
    public function openImageInformationView(Request $request) {
        $image = DB::select("
            SELECT
                images.id as id,
                images.title as title,
                images.description as img_description,
                images.rating as rating,
                images.image as img_url,
                images.creation_date as creation_date,
                collections.name as coll_name,
                collections.description as coll_description,
                images_for_sale.price as price,
                users.username as seller_name
            FROM images_for_sale
            INNER JOIN images
                ON images_for_sale.fk_image_id = images.id
            INNER JOIN collections
                ON images.fk_collection_id_dabartine = collections.id
            INNER JOIN users
                ON images.fk_user_id_savininkas = users.id
            WHERE images.id = ".$request->id
        );

        return view('ImageInformationView', compact('image'));
    }
}
