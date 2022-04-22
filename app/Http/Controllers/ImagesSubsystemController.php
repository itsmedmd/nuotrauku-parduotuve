<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\image_for_sale;

class ImagesSubsystemController extends Controller
{
    public function TESTdoSomething()
    {
        // returns json data
        return response()->json(
            [
                'status'=> 'error',
                'message'=> 'oof'
            ]
        );
    }

    public function getImagesForSale() {
        $images = DB::select('SELECT * FROM images_for_sale');
        return view('ImagesListView', compact('images'));
    }
}
