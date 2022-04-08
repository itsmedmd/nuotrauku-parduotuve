<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImagesManagementSubsystemController extends Controller
{
    private function validateNewImageData(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|max:200',
            'image' => 'required|image',
            'description' => 'max:500'
        ]);
    }

    public function submitNewImageCreation(Request $request)
    {
        $USER_ID = 1;

        $this->validateNewImageData($request);
 
        // save the image file in storage/public/images
        $path = $request->file('image')->store('public/images');

        // create new image entry in the database
        $img = new image;
        
        $img->title = $request->title;
        $img->description = $request->description;
        $img->rating = 0;
        $img->price = $request->price;
        $img->is_visible = true;
        $img->fk_collection_id_dabartine = NULL;
        $img->fk_collection_id_originali = NULL;
        $img->fk_user_id_savininkas = $USER_ID;
        $img->fk_user_id_kurejas = $USER_ID;
        $img->image = $path;

        $img->save();
        
        //return redirect('ImageCreationView')->with('success-status', 'New image successfully created!');
        return redirect('CreatedImagesListView')->with('success-status', 'New image successfully created!');

    }
}
