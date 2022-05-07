@section('styles')
<link rel="stylesheet" href="{{ asset('css/images-for-sale-list-view.css') }}">
@endsection

@extends('layouts/layout')

@section('content')
<main class="content">
    <h1 class="page-title">Created Images List</h1>
    <div class="created-images-list-new-image">
        <button class="button" onclick="openAuctionCreationView()">
            Create New Auction
        </button>
    </div>
    @if(session('success-status'))
        <div class="status-container">
            <h2 class="success">{{ session('success-status') }}</h2>
        </div>
    @endif
    @foreach($auctions as $item)
                <p class="created-images-list-item-name">{{ $item->price }}</p>
            @endforeach
   
</main>
@endsection

@section('js')
<script>
    const openAuctionCreationView = () => {
        window.location.href = "/AuctionRegistrationView";
    };
</script>
@endsection
