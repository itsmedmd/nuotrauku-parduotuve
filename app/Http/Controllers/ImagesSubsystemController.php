<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\image_for_sale;
use App\Models\image_rating;
use App\Models\image;

class ImagesSubsystemController extends Controller
{
    private $USER_ID = 1;

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
                images_for_sale.id as id,
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
                    images_for_sale.id as id,
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
        // get image data
        $image = DB::select("
            SELECT
                images_for_sale.id as image_for_sale_id,
                images.id as image_id,
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
            WHERE images_for_sale.id = ".$request->id
        );

        // get image comments
        $comments = DB::select("
            SELECT
                comments.comment as comment,
                comments.date as date,
                users.username as author,
                users.profile_picture as author_img
            FROM comments
            INNER JOIN users
                ON comments.fk_user_id = users.id
            WHERE comments.fk_image_for_sale_id = ".$request->id."
            ORDER BY comments.date DESC
        ");

        // check if the user rated this image
        $user_rated_img = DB::select("
            SELECT rating
            FROM image_ratings
            WHERE fk_user_id_vertintojas = ".$this->USER_ID."
            AND fk_image_id = ".$image[0]->image_id
        );

        return view('ImageInformationView', compact('image', 'comments', 'user_rated_img'));
    }

    // rate image
    public function rateImage(Request $request) {
        $add_to_total = 0;
        
        // create new rating object
        $new_rating = new image_rating;
        $new_rating->fk_user_id_vertintojas = $this->USER_ID;
        $new_rating->fk_image_id = $request->id;

        if ($request->rating == 'true') {
            $new_rating->rating = true;
            $add_to_total = 1;
        } else {
            $new_rating->rating = false;
            $add_to_total = -1;
        }

        // check if the user already rated this image
        $img_rating = DB::select("
            SELECT id, rating
            FROM image_ratings
            WHERE fk_user_id_vertintojas = ".$this->USER_ID."
            AND fk_image_id = ".$request->id
        );

        // if old rating exists, update final image rating count
        if (count($img_rating) > 0) {
            if ($img_rating[0]->rating) {
                $add_to_total = $add_to_total - 1;
            } else {
                $add_to_total = $add_to_total + 1;
            }
        }
        
        // if the user already rated the image
        if ($img_rating) {
            // check if new and old ratings are different
            $is_rating_different = true;
            if ($img_rating[0]->rating == $new_rating->rating) {
                $is_rating_different = false;
                // if rating is the same, the rating will be reversed
                // (+1 becomes -1 and -1 becomes +1)
                if ($img_rating[0]->rating) {
                    $add_to_total = $add_to_total - 1;
                } else {
                    $add_to_total = $add_to_total + 1;
                }
            }

            // first delete the old rating
            image_rating::destroy($img_rating[0]->id);

            // if the ratings are different - add new rating to DB
            if ($is_rating_different) {
                $new_rating->save();
            }
        } else {
            // add new rating to DB
            $new_rating->save();
        }

        // update total image rating
        image::whereId($request->id)->update([
            'rating'=> DB::raw('rating+'.$add_to_total)
        ]);
        
        // return the same page but it will retrieve updated data
        return back();
    }
}
