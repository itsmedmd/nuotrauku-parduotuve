<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
