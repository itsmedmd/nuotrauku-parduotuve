@section('styles')
<link rel="stylesheet" href="{{ asset('css/images-for-sale-list-view.css') }}">
@endsection

@extends('layouts/layout')

@section('content')
<main class="content">
    <h1 class="page-title">Auctions List</h1>
    <div class="created-images-list-new-image">
        <button class="button" onclick="openAuctionRegistrationView()">
            Create New Auction
        </button>
    </div>
    @if(session('success-status-auctions'))
        <div class="status-container">
            <h2 class="success">{{ session('success-status-auctions') }}</h2>
        </div>
    @endif
    <div class="created-images-list-container">
        @if (count($auctionImages) == 0)
            <h2>There are no active auctions</h2>
        @endif

        <ul class="created-images-list">
            @foreach($auctionImages as $item)
                <li class="created-images-list-item">
                    <img
                        src="{{ asset($item->image) }}"
                        alt="{{ $item->title }}"
                        class="created-images-list-image"
                    >
                    <button
                            class="button button-default-actions"
                            onclick="openAuctionInformationView({{ $item->id }})"
                        >
                            <a href="{{ route('openAuctionInformationView', ['id' => $item->id]) }}">
                                Information
                            </a> 
                        </button>
                    <p class="created-images-list-item-name">{{ $item->title }}</p>
                </li>
            @endforeach
        </ul>
    </div>
   
</main>
@endsection

@section('js')
<script>
    const openAuctionRegistrationView = () => {
        window.location.href = "/AuctionRegistrationView";
    };
</script>
@endsection
