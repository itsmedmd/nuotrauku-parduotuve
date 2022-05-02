@section('styles')
<link rel="stylesheet" href="{{ asset('css/image-information-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<main class="content">
    <div class="image-information-view__content">
        <div class="image-information-view__row">
            <div class="image-information-view__rating-container">
                @if (count($user_rated_img) > 0)
                    @if($user_rated_img[0]->rating == true)
                        <a
                            href="{{ route('rateImage', ['id' => $image[0]->image_id, 'rating' => 'true']) }}"
                            class="image-information-view__rate-up image-information-view__rate-up--active"
                        >
                            &#129093;
                        </a>
                        <a
                            href="{{ route('rateImage', ['id' => $image[0]->image_id, 'rating' => 'false']) }}"
                            class="image-information-view__rate-down"
                        >
                            &#129095;
                        </a>
                    @else
                        <a
                            href="{{ route('rateImage', ['id' => $image[0]->image_id, 'rating' => 'true']) }}"
                            class="image-information-view__rate-up"
                        >
                            &#129093;
                        </a>
                        <a
                            href="{{ route('rateImage', ['id' => $image[0]->image_id, 'rating' => 'false']) }}"
                            class="image-information-view__rate-down image-information-view__rate-down--active"
                        >
                            &#129095;
                        </a>
                    @endif
                @else
                    <a
                        href="{{ route('rateImage', ['id' => $image[0]->image_id, 'rating' => 'true']) }}"
                        class="image-information-view__rate-up"
                    >
                        &#129093;
                    </a>
                    <a
                        href="{{ route('rateImage', ['id' => $image[0]->image_id, 'rating' => 'false']) }}"
                        class="image-information-view__rate-down"
                    >
                        &#129095;
                    </a>
                @endif
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
            <a
                href="{{ route('imagePriceHistoryView', ['id' => $image[0]->image_id]) }}"
                class="image-information-view__price-history-button"
            >
                Show Price History
            </a>
        </div>
    </div>
    <div class="image-information-view__comments">
        <h2 class="image-information-view__comments-title">Comments</h2>
        <div class="image-information-view__comments-content">
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
            @if (count($comments) == 0)
                <h2 class="image-information-view__no-comments-msg">There are no comments yet</h2>
            @endif
            @if (count($comments) > 0)
                <div class="image-information-view__comments-list">
                    @foreach($comments as $comment)
                        <div class="image-information-view__comment-container">
                            <img
                                src="{{ asset($comment->author_img) }}"
                                alt="{{ $comment->author }}"
                                class="image-information-view__comment-author-image"
                            >

                            <div class="image-information-view__comment-content">
                                <p class="image-information-view__comment-author">
                                    {{$comment->author}}
                                    <span class="image-information-view__comment-date">{{$comment->date}}</span>
                                </p>
                                <p class="image-information-view__comment-text">{{$comment->comment}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="image-information-view__recommendations">
        <h2 class="image-information-view__recommendations-title">Recommendations</h2>
        <div class="image-information-view__recommendations-list" id="recommendations">
        </div>
        <button onclick="getRecommendations()" class="image-information-view__new-recommendations-button">New Recommendations</button>
    </div>
</main>
@endsection

@section('js')
<script>
    const csrfToken = '{{csrf_token()}}';
    const image = @json($image);
    const recommendations_element = document.getElementById("recommendations");
    let recommendations = [];

    const getRecommendations = () => {
        $.ajax({
            url: "{{ route('getImageRecommendations') }}",
            type: "POST",
            data: JSON.stringify({
                img_id: image[0].image_id,
                image_for_sale_id: image[0].image_for_sale_id,
                coll_id: image[0].coll_id,
                seller_id: image[0].seller_id,
                img_title: image[0].title,
                img_description: image[0].img_description
            }),
            dataType: "JSON",
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.recommendations) {
                    recommendations = response.recommendations.slice(0, 5);
                    recommendations.forEach((rec) => {
                        const item = document.createElement("a");
                        item.classList.add("image-information-view__recommendation__card");
                        item.href = `/imageInformationView/${rec.image_for_sale_id}`;

                        const img = document.createElement("img");
                        img.alt = rec.title;
                        img.classList.add("image-information-view__recommendation__card-image");
                        img.src = `/${rec.img_url}`;

                        item.appendChild(img);
                        recommendations_element.appendChild(item);
                    });
                }
            },
            error: function(err) {
                console.log("error: ", err);
            }
        });
    };

    getRecommendations();
</script>
@endsection
