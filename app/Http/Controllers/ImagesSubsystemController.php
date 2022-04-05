<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImagesSubsystemController extends Controller
{
    public static function TESTnavigateToLogin()
    {
        return view('LoginView');
    }

    public static function TESTgetResponse()
    {
        return response()->json(
            [
                'status'=> 'error',
                'message'=> 'oof'
            ]
        );
    }
}
