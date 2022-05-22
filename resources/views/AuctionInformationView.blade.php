@extends('layouts/layout')
@section('content')
<main class="content">

@php
use App\Http\Controllers\AuctionsSubsystemController;
$item = $auct[0];
$useris = $user[0];
@endphp

    @if($status_auct)
        <div class="status-container">
            <h2 class="success">{{ $status_auct }}</h2>
        </div>
    @endif

    <div><h1>{{$item->title}}</h1></div>
    <img src="{{ asset($item->image) }}"
        alt="{{ $item->title }}"
        class="created-images-list-image">
    <h3>{{$item->description}}</h3>
    <h3>Started: {{$item->creation_date}}</h3>
    <h3>Ends: {{$item->end_date}}</h3>
    <h3>Current price: {{$item->price}}</h3>
    <h3>MinimumBid: {{$item->minimum_bid_raise}}</h3>
    <h3>Priklauso dabar: {{$item->username}}</h3>
    
    @if ( AuctionsSubsystemController::checkIfCurrentUserIsAuctionCreator($item,$useris))
    <form method="post" action="{{ route('submitAuctionBid')}}">
            @csrf
            <input name="auction_id" type="hidden" value="{{$item->auctionID}}">
            <input name="user_id" type="hidden" value="{{$item->usersID}}">
            <div>
            <input name="price" id="price" type="number" min={{$item->minimum_bid_raise}} step=1 required>
        </div>
        <div>
            <input type="submit" value="Bid" class="button-default-actions" />
        </div>
        </form>
       
    @endif

   
</main>
@endsection

@section('js')
<script>
</script>
@endsection