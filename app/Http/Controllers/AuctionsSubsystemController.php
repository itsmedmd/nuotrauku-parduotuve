<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\auction;
use App\Models\auction_bid;
use App\Models\image;
use App\Models\User;
use Carbon\Carbon;

class AuctionsSubsystemController extends Controller
{
    private $USER_ID = 2;
    
    public function getChosenAuction($id)
    {
        $auct = DB::table('auctions')   
        ->where('auctions.id', $id)
        ->join('images','auctions.fk_image_id','=','images.id')
        ->join('users','users.id','=','images.fk_user_id_savininkas')
        ->select('auctions.*', 'images.*', 'users.*', 'auctions.id AS auctionID',
        'users.id AS usersID', 'images.id AS imagesID', 'images.price AS imgPrice',
        'auctions.price AS price')
        ->limit(1)
        ->get();

        return $auct;
    }

    public function getAuctionsList() {
        $auctionImages = DB::table('images') 
        ->join('auctions','auctions.fk_image_id','=','images.id')
        ->select('images.id','images.title','images.image',
         'images.fk_user_id_savininkas', 'images.fk_user_id_kurejas',
          'auctions.id')
        ->where('auctions.status','!=', 'ended')
        ->orderBy('auctions.id')  
        ->get();
        return view('AuctionsListView', compact('auctionImages'));
    }

    // validate new auction data
    private function validateAuctionRegistrationData(Request $request) {
        $validatedData = $request->validate([
            'minimum_bid_raise' => 'min:0',
            'price' => 'required|min:0',
            'end_date' => 'required',
            'fk_image_id' => 'required'
        ]);
    }

    // validate new auction bid data
    private function validateAuctionBidData(Request $request) {
        $validatedData = $request->validate([
            'price' => 'required|min:0'
        ]);
    }

     // create new auction
     public function registerAuction(Request $request)
     {
        $this->validateAuctionRegistrationData($request);
 
        // create new auction entry in the database
        $auct = new auction;
        $auct->end_date = $request->end_date;
        $auct->price = $request->price;
        $auct->initial_price = $request->price;
        $auct->minimum_bid_raise = $request->minimum_bid_raise;
        $auct->fk_image_id = $request->fk_image_id;
 
        $auct->save();
         
        return redirect('AuctionsListView')->with('success-status-auctions', 'New auction successfully created!');
     }

    // create new auction bid
    public function submitAuctionBid(Request $request)
    {      
        $this->validateAuctionBidData($request);
        $auct = $this->getChosenAuction($request->auction_id);
        $sum = $request->price + $auct[0]->price;
        $auctionEndTime = auction::whereId($auct[0]->auctionID)->get('end_date');
        $user = User::whereId($this->USER_ID)->get();

        if($this->doesUserHaveEnoughBalance($sum, $user) && strtotime($auctionEndTime) <= Carbon::now())
        {
            // create new auction bid entry in the database
            $bid = new auction_bid;
            $bid->price = $sum;
            $bid->fk_auction_id = $request->auction_id;
            $bid->fk_user_id = $user[0]->id;
            $bid->save();
            auction::whereId($auct[0]->auctionID)->update([
                'price' => $sum,
            ]);

            

            if($this->checkIfAuctionTimeIsLongerThenOneMinute($auctionEndTime))
            {
                $newDateTime = Carbon::now('GMT+3')->addMinute();
                auction::whereId($auct[0]->auctionID)->update([
                    'end_date' => $newDateTime
                ]);
            }
        
            return view('AuctionInformationView')->with([
                'status_auct' => 'New bid placed!',
                'auct' => $auct,
                'user' => $user]);
        }   

        return view('AuctionInformationView')->with([
            'status_auct' => 'Balance too small or time expired',
            'auct' => $auct,
            'user' => $user]);
    }

    private function doesUserHaveEnoughBalance($price, $user)
    {
        $userBalance = User::whereId($user[0]->id)->get();
        if($userBalance[0]->wallet_balance >= $price) return true;
        return false;
    }

    private function checkIfAuctionTimeIsLongerThenOneMinute($given_time)
    {
        if (strtotime($given_time) <= Carbon::now()->subMinute()) return true;
        return false;
    }

     // open auction creation view with avaivable image list to select from
    public function openImageCreationView() 
    {
       // $activeAuctions = auction::where('status', 'ongoing')->get();
        $avaivableImageNames = image::where('fk_user_id_savininkas', $this->USER_ID)->get();

        return view('AuctionRegistrationView', compact('avaivableImageNames'));
    }

    // open information auction view with selected auction information
    public function openAuctionInformationView($id)
    {
        $auct = $this->getChosenAuction($id);
        $user = User::whereId($this->USER_ID)->get();

        return view('AuctionInformationView')->with([
            'status_auct' => '',
            'auct' => $auct,
            'user' => $user]);
    }
    //Hide ability to place a bid?
    public static function checkIfCurrentUserIsAuctionCreator($user, $thatUser)
    {
        if ($user->fk_user_id_savininkas==$thatUser->id){
            return false;
        }
        return true;
    }
    

    public static function displayRecomendedPrice($currentCollectionID)
    {
        $imagesPrices = image::where('fk_user_id_savininkas', $currentCollectionID)
        ->get('price');

        $totalSum = static::calculateAveragePriceFromAllUserImages($imagesPrices);
        
        return static::checkIfThereAreImagesWithPrice($totalSum);
    }

    private static function calculateAveragePriceFromAllUserImages($prices)
    {
        $counter = 0;
        foreach($prices as $item)
        {
            $counter += $item->price;
        }
        return $counter/count($prices);
    }

    private static function checkIfThereAreImagesWithPrice($total)
    {
        if($total > 0)return $total;
        return 'Cant format suggested price';
    }



}
