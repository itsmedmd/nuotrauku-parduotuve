<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\auction;

class AuctionsSubsystemController extends Controller
{
    // open created auctions list
    public function displayAuctionsList() {
        $auctions = [];
        return view('AuctionsListView', compact('auctions'));
    }
}
