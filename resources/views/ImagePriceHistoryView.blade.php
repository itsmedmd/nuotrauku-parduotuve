@section('styles')
<link rel="stylesheet" href="{{ asset('css/image-information-view.css') }}">
<link rel="stylesheet" href="{{ asset('css/image-price-history-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<main class="content">
    @if (count($bills) == 0)
        <h2 class="image-information-view__no-comments-msg">This image has no price history</h2>
    @endif
    @if (count($bills) > 0)
        <div id="price-plot"></div>

        <h2 class="image-information-view__comments-title image-price-history-view__title">Purchase history:</h2>
        <div class="image-information-view__comments-list">
            @foreach($bills as $bill)
                <div class="image-information-view__comment-container">
                    <img
                        src="{{ asset($bill->profile_img) }}"
                        alt="{{ $bill->username }}"
                        class="image-information-view__comment-author-image"
                    >

                    <div class="image-information-view__comment-content">
                        <p class="image-information-view__comment-author">
                            {{$bill->username}}
                            <span class="image-information-view__comment-date">{{$bill->date}}</span>
                        </p>
                        <p class="image-information-view__comment-text">Price: {{$bill->price}}$</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
@endsection

@section('js')
<script>
    const bills = @json($bills);
    
    // if there are bills - draw a line graph
    if (bills.length) {
        const data = {
            x: [],
            y: [],
            type: "scatter"
        };

        bills.forEach((bill) => {
            data.x.push(bill.date);
            data.y.push(bill.price);
        });

        Plotly.newPlot("price-plot", [data]);
    }

</script>
@endsection
