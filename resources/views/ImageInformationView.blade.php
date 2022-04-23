@section('styles')
<link rel="stylesheet" href="{{ asset('css/image-information-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<main class="content">
    <div class="image-information-view__content">
        <div class="image-information-view__row">
            <div class="image-information-view__rating-container">
                <a href="/" class="image-information-view__rate-up">&#129093;</a>
                <a href="/" class="image-information-view__rate-down">&#129095;</a>
                <p class="image-information-view__rating">{{$image[0]->rating}}</p>
            </div>
            <img
                src="{{ asset($image[0]->img_url) }}"
                alt="{{ $image[0]->title }}"
                class="image-information-view__image"
            >
            <div class="image-information-view__image-text">
                <h1 class="image-information-view__image-title">{{$image[0]->title}}</h1>
                <h2 class="image-information-view__image-price">{{$image[0]->price}}$</h2>
                <h3 class="image-information-view__image-creation-date">Created at {{$image[0]->creation_date}}</h3>
                <h3 class="image-information-view__image-seller">
                    Current owner: <span class="image-information-view__image-seller-name">{{$image[0]->seller_name}}</span>
                </h3>
                <h3 class="image-information-view__image-coll">Collection:</h3>
                <h4 class="image-information-view__image-coll-name">Title: <b>{{$image[0]->coll_name}}</b></h4>
                <h4 class="image-information-view__image-coll-desc">Description: <b>{{$image[0]->coll_description}}</b></h4>
                <h3 class="image-information-view__image-desc-title">Image description:</h3>
                <h4 class="image-information-view__image-desc">{{$image[0]->img_description}}</h4>
            </div>
        </div>
        <div class="image-information-view__row">
            <a href="/" class="image-information-view__buy-button">Buy Now</a>
            <a href="/" class="image-information-view__price-history-button">Show Price History</a>
        </div>
    </div>
    <div class="image-information-view__comments">
        <h2 class="image-information-view__comments-title">Comments</h2>
        <form class="image-information-view__comment-form" action="/" method="post">
            <input
                type="text"
                name="text"
                class="image-information-view__comment-input"
                required
                placeholder="Write a comment..."
            >
            <input
                class="form-submit-button image-information-view__comment-submit"
                type="submit"
                value="Comment"
            />
        </form>
        <div class="image-information-view__comments-list">
            <div class="image-information-view__comment-container">
                <span>IMG</span>
                <p>author <span> comment date </span></p>
                <p>comment here!!!!!!!!!!!</p>
            </div>
        </div>
    </div>
    <div class="image-information-view__recommendations">
        <div class="image-information-view__recommendations-list">
            recommendations here
        </div>
        <a href="/" class="image-information-view__new-recommendations-button">New Recommendations</a>
    </div>
</main>
@endsection

@section('js')
<script>
</script>
@endsection
