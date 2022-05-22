<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\image_for_sale;
use App\Models\image_rating;
use App\Models\image;
use App\Models\comment;

class ImagesSubsystemController extends Controller
{
    private $USER_ID = 1;

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
                users.username as seller_name,
                images.fk_user_id_savininkas as seller_id,
                images.fk_collection_id_dabartine as coll_id
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

    // open image information price history view
    public function openImagePriceHistoryView(Request $request) {
        // get all image bills
        $bills = DB::select("
            SELECT
                bills.date as date,
                bills.price as price,
                users.username as username,
                users.profile_picture as profile_img
            FROM bills
            INNER JOIN users
                ON bills.fk_user_id = users.id
            WHERE bills.fk_image_id = ".$request->id."
            ORDER BY bills.date DESC
        ");

        return view('ImagePriceHistoryView', compact('bills'));
    }

    // get recommendations for an image
    public function getImageRecommendations(Request $request) {
        // get parameters from request
        $image_for_sale_id = $request->input('image_for_sale_id');
        $old_ids = $request->collect('old_ids');

        // get image data needed for recommendations
        $image = DB::select("
            SELECT
                images.id as image_id,
                images.title as title,
                images.description as img_description,
                images.fk_user_id_savininkas as seller_id,
                images.fk_collection_id_dabartine as coll_id
            FROM images_for_sale
            INNER JOIN images
                ON images_for_sale.fk_image_id = images.id
            INNER JOIN collections
                ON images.fk_collection_id_dabartine = collections.id
            INNER JOIN users
                ON images.fk_user_id_savininkas = users.id
            WHERE images_for_sale.id = ".$image_for_sale_id
        );

        $img_id = $image[0]->image_id;
        $coll_id = $image[0]->coll_id;
        $seller_id = $image[0]->seller_id;
        $img_title = $image[0]->title;
        $img_description = $image[0]->img_description;

        // do not return images that have already been recommended
        $do_not_recommend = "";
        foreach ($old_ids as $key => $val) {
            $do_not_recommend = $do_not_recommend." AND NOT images_for_sale.id = ".$val;
        }

        // select 5 most recent images from the same collection
        $recommendations = DB::select("
            SELECT
                images.image as img_url,
                images.title as title,
                images.description as description,
                images_for_sale.id as image_for_sale_id
            FROM images_for_sale
                INNER JOIN images
                    ON images_for_sale.fk_image_id = images.id
            WHERE images.fk_collection_id_dabartine = ".$coll_id."
                AND NOT images_for_sale.id = ".$image_for_sale_id.$do_not_recommend."
            ORDER BY images.creation_date DESC
            LIMIT 5
        ");

        if (count($recommendations) < 5) {
            // do not return images that are in $recommendations array
            $images_to_not_include = $do_not_recommend;
            foreach ($recommendations as $key => $val) {
                $images_to_not_include = $images_to_not_include." AND NOT images_for_sale.id = ".$val->image_for_sale_id;
            }

            $from_same_seller = DB::select("
                SELECT
                    images.image as img_url,
                    images.title as title,
                    images.description as description,
                    images_for_sale.id as image_for_sale_id
                FROM images_for_sale
                    INNER JOIN images
                        ON images_for_sale.fk_image_id = images.id
                WHERE images.fk_user_id_savininkas = ".$seller_id."
                    AND NOT images_for_sale.id = ".$image_for_sale_id.$images_to_not_include."
                ORDER BY images.rating DESC
                LIMIT 5
            ");

            // add new images
            $recommendations = array_merge($recommendations, $from_same_seller);

            if (count($recommendations) < 5) {
                // do not return images that are in $recommendations array
                $images_to_not_include = $do_not_recommend;
                foreach ($recommendations as $key => $val) {
                    $images_to_not_include = $images_to_not_include." AND NOT images_for_sale.id = ".$val->image_for_sale_id;
                }

                $all_images_for_sale = DB::select("
                    SELECT
                        images.image as img_url,
                        images.title as title,
                        images.description as description,
                        images_for_sale.id as image_for_sale_id
                    FROM images_for_sale
                        INNER JOIN images
                            ON images_for_sale.fk_image_id = images.id
                    WHERE NOT images_for_sale.id = ".$image_for_sale_id.$images_to_not_include
                );

                // count words in titles and descriptions similarity by percentage
                $percentages = [];
                foreach ($all_images_for_sale as $key => $val) {
                    $title = strtoupper($val->title);
                    $description = strtoupper($val->description);

                    similar_text(strtoupper($img_title), $title, $percent_title);
                    similar_text(strtoupper($img_description), $description, $percent_description);

                    $combined_similarity = ($percent_title + $percent_description) / 2;
                    $item = (object) ['image_for_sale_id' => $val->image_for_sale_id, 'similarity' => $combined_similarity];
                    array_push($percentages, $item);
                }

                // sort $percentages by similarity descending
                usort($percentages, function($a, $b) {
                    return $a->similarity < $b->similarity ? 1 : -1;
                });

                // add 5 new images based on highest percentage of title and description similarity
                $similar_recommendations = [];
                for ($i = 0; $i < 5; $i++) {
                    if (count($percentages) == $i) {
                        break;
                    }
                    $image_id = $percentages[$i]->image_for_sale_id;
                    $item_id = array_search($image_id, array_column($all_images_for_sale, 'image_for_sale_id'));
                    array_push($similar_recommendations, $all_images_for_sale[$item_id]);
                }

                $recommendations = array_merge($recommendations, $similar_recommendations);

                if (count($recommendations) < 5) {
                    // do not return images that are in $recommendations array
                    $images_to_not_include = $do_not_recommend;
                    foreach ($recommendations as $key => $val) {
                        $images_to_not_include = $images_to_not_include." AND NOT images_for_sale.id = ".$val->image_for_sale_id;
                    }

                    $first_5_from_all_images = DB::select("
                        SELECT
                            images.image as img_url,
                            images.title as title,
                            images.description as description,
                            images_for_sale.id as image_for_sale_id
                        FROM images_for_sale
                            INNER JOIN images
                                ON images_for_sale.fk_image_id = images.id
                        WHERE NOT images_for_sale.id = ".$image_for_sale_id.$images_to_not_include."
                        ORDER BY images.rating DESC
                        LIMIT 5
                    ");

                    $recommendations = array_merge($recommendations, $first_5_from_all_images);
                }
            }
        }

        return response()->json(
            [
                'recommendations' => $recommendations
            ]
        );
    }

    public function getImageInformation(Request $request) {
        // get parameters from request
        $image_for_sale_id = $request->input('image_for_sale_id');

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
                users.username as seller_name,
                images.fk_user_id_savininkas as seller_id,
                images.fk_collection_id_dabartine as coll_id
            FROM images_for_sale
            INNER JOIN images
                ON images_for_sale.fk_image_id = images.id
            INNER JOIN collections
                ON images.fk_collection_id_dabartine = collections.id
            INNER JOIN users
                ON images.fk_user_id_savininkas = users.id
            WHERE images_for_sale.id = ".$image_for_sale_id
        );

        // get image comments
        $comments = DB::select("
            SELECT
                comments.id as commentid,
                comments.comment as comment,
                comments.date as date,
                users.username as author,
                users.profile_picture as author_img
            FROM comments
            INNER JOIN users
                ON comments.fk_user_id = users.id
            WHERE comments.fk_image_for_sale_id = ".$image_for_sale_id."
            ORDER BY comments.date DESC
        ");

        // check if the user rated this image
        $user_rated_img = DB::select("
            SELECT rating
            FROM image_ratings
            WHERE fk_user_id_vertintojas = ".$this->USER_ID."
            AND fk_image_id = ".$image[0]->image_id
        );

        return response()->json(
            [
                'image' => $image,
                'comments' => $comments,
                'user_rated_img' => $user_rated_img,
            ]
        );
    }

    public function createComment(Request $request)
    {
        // create new comment entry in the database
        $comment = new comment;
        $comment->comment = $request->text;
        $comment->fk_user_id = $this->USER_ID;
        $comment->fk_image_for_sale_id = $request->id;
        $comment->save();

        return redirect()->back();
    }

    public function openCommentEditForm($id)
    {
        $comm = comment::where('id', $id)->get();
        return view('CommentEditForm')->with('comment' ,$comm[0]);
    }

    public function editComment(Request $request)
    {
        //Update comment
        comment::where('id', $request->id)
        ->update([
            'comment' => $request->commentValue
        ]);

        return redirect()->back()->with('status' ,'Comment successfuly updated');
    }

    public function deleteComment(Request $request)
    {
        //Update comment
        comment::where('id', $request->id)->delete();

        return redirect()->back();
    }

    // open delete image view
    public function submitCommentDelete($id) {
        return redirect()->back()->with([
            'openCommentActionForm' => true,
            'itemID' => $id
        ]);
    }

}
