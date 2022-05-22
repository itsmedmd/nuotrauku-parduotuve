<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserManagementSubsystemController extends Controller
{
    private $USER_ID = 1;
    public function openWallet() {
        $user = User::where('id', $this->USER_ID)->get();
        return view('WalletView')->with([
            'item' => $user[0]]);
    }

    public function openWalletTopUpView($id){
        $user = User::where('id', $this->USER_ID)->get();
        return view('WalletBalanceTopUpView')->with([
            'item' => $user[0]]);
    }

    private function validateTopUpValue(Request $request) {
        $validatedData = $request->validate([
            'price' => 'required|min:0'
        ]);
    }

    public function submitTopUpValue(Request $request)
    {
        $user = User::where('id', $this->USER_ID)->get();
       $this->validateTopUpValue($request);

       User::where('id', $request->id)->increment('wallet_balance', $request->price);

       return redirect('WalletView')->with('success-status', 'New image successfully created!');
    }
}
