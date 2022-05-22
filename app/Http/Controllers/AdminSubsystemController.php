<?php

namespace App\Http\Controllers;
use app\Models\admin;
use app\Models\image;
use app\Models\user;
use App\Models\image_for_sale;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\DB;

class AdminSubsystemController extends Controller
{
    public function submitImageDelete($id) {
        return redirect('imageInformationView')->with([
            'openActionConfirmationForm' => true,
            'itemID' => $id
        ]);
    }

    // delete image
    public function deleteImage($id) {
        $img = image::findOrFail($id);

        // delete image file from storage 
        $path_arr = explode("/", $img->image); 
        $path_in_storage = 'public/'.$path_arr[1].'/'.$path_arr[2];
        Storage::delete($path_in_storage);

        // delete image form the database
        $img->delete();

        return redirect('imageInformationView')->with('success-status', 'Image successfully deleted!');
    }
}
