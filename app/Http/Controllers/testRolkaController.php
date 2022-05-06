<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class testRolkaController extends Controller
{
    public function openOwnedImageInformationView($id)
    {
        $image = DB::table('images')->find($id);   //vienam
        //return view('OwnedImageInformationView')->with('image', $image);

        // $sk = $image->title;   
        return view('OwnedImageInformationView', [
            'image' => $image,
        ]);
    }

    public function notShow($id)
    {
        $image = DB::table('images')->find($id);   //vienam
        return view('OwnedImageInformationView')->with('image', $image);

        // $sk = 0;
        // $sk = $image->title;   
        // return view('OwnedImageInformationView', [
        //     'image' => $image,
        //     'sk' => $sk
        // ]);
    }

    public function changeVisibility($id)
    {
        // dd('in CHANGE VISIBILITY');
        $image = DB::table('images')->find($id);   //vienam
        Debugbar::info($image->is_visible);
        if($image->is_visible == 0)
        {
            Debugbar::info('ieita i iF');
            $image = DB::update('UPDATE images set is_visible = ? where id = ?', [
                1, 1
            ]);
        }
        else
        {
            Debugbar::info('ieita i iF else');
            $image = DB::update('UPDATE images set is_visible = ? where id = ?', [
                0, 1
            ]); 
        }
        $image = DB::table('images')->find($id);   //vienam

        return view('OwnedImageInformationView', [
            'image' => $image,
        ]);


        //return view('OwnedImageInformationView')->with('image', $image);
        // $image = DB::table('images')->find($id);   //vienam

        // $image = DB::table('images')->update()



        // return view('OwnedImageInformationView')->with('image', $image);
    }
}
