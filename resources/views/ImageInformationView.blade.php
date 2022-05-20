@section('styles')
<link rel="stylesheet" href="{{ asset('css/image-information-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<main class="content">
    <div class="image-information-view__content">
        <div class="image-information-view__row">
            <div class="image-information-view__rating-container">
                <a class="image-information-view__rate-up" id="rate-up">
                    &#129093;
                </a>
                <a class="image-information-view__rate-down" id="rate-down">
                    &#129095;
                </a>
                <p class="image-information-view__rating" id="rating"></p>
            </div>
            <img class="image-information-view__image" id="image">
            <div class="image-information-view__image-text">
                <h1 class="image-information-view__image-title" id="title"></h1>
                <h2 class="image-information-view__image-price" id="price"></h2>
                <h3 class="image-information-view__image-creation-date" id="creation_date"></h3>
                <h3 class="image-information-view__image-seller">
                    Current owner: <span class="image-information-view__image-seller-name" id="seller_name"></span>
                </h3>
                <h3 class="image-information-view__image-coll">Collection:</h3>
                <h4 class="image-information-view__image-coll-name">Title: <b id="coll_name"></b></h4>
                <h4 class="image-information-view__image-coll-desc">Description: <b id="coll_description"></b></h4>
                <h3 class="image-information-view__image-desc-title">Image description:</h3>
                <h4 class="image-information-view__image-desc" id="img_description"></h4>
            </div>
        </div>
        <div class="image-information-view__row">
            <a href="/" class="image-information-view__buy-button">Buy Now</a>
            <a
                id="price_history_button"
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
            <h2 class="image-information-view__no-comments-msg" id="comments-title">There are no comments yet</h2>
            <div class="image-information-view__comments-list" id="comments-list"></div>
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
    const path = window.location.href.split("/");
    const image_for_sale_id = path[path.length - 1];

    let image = null;
    let comments = null;
    let user_rated_img = null;

    const recommendations_element = document.getElementById("recommendations");
    let recommendations = [];
    let all_recommendations_ids = new Set();

    const getInformation = () => {
        $.ajax({
            url: "{{ route('getImageInformation') }}",
            type: "POST",
            data: JSON.stringify({
                image_for_sale_id: image_for_sale_id
            }),
            dataType: "JSON",
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                image = response.image[0];
                comments = response.comments;
                user_rated_img = response.user_rated_img;
                renderInformation();
            },
            error: function(err) {
                console.log("error: ", err);
            }
        });
    };

    const getRecommendations = () => {
        $.ajax({
            url: "{{ route('getImageRecommendations') }}",
            type: "POST",
            data: JSON.stringify({
                image_for_sale_id: image_for_sale_id,
                old_ids: Array.from(all_recommendations_ids)
            }),
            dataType: "JSON",
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.recommendations) {
                    recommendations_element.innerHTML = ""; // remove all old elements from the DOM
                    recommendations = response.recommendations.slice(0, 5);

                    // if response returned no recommendations and if previously
                    // there were recommendations, clear old recommendations and
                    // start recommending from the start again
                    if (!recommendations.length && all_recommendations_ids.size) {
                        all_recommendations_ids.clear();
                        getRecommendations();
                    } else {
                        recommendations.forEach((rec) => {
                            all_recommendations_ids.add(rec.image_for_sale_id);

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
                }
            },
            error: function(err) {
                console.log("error: ", err);
            }
        });
    };

    const renderInformation = () => {
        // rating
        const ratingEl = document.getElementById("rating");
        ratingEl.innerText = image.rating;

        const rateUpEl = document.getElementById("rate-up");
        rateUpEl.href = `/rateImage/${image.image_id}/true`;

        const rateDownEl = document.getElementById("rate-down");
        rateDownEl.href = `/rateImage/${image.image_id}/false`;

        if (user_rated_img.length) {
            if (user_rated_img[0].rating) {
                rateUpEl.classList.add("image-information-view__rate-up--active");
            } else {
                rateDownEl.classList.add("image-information-view__rate-down--active");
            }
        }

        // price history button
        const price_history_buttonEl = document.getElementById("price_history_button");
        price_history_buttonEl.href = `/imagePriceHistoryView/${image.image_id}`;

        // image information
        const imageEl = document.getElementById("image");
        imageEl.src = "/" + image.img_url;
        imageEl.alt = image.title;

        const titleEl = document.getElementById("title");
        titleEl.innerText = image.title;

        const priceEl = document.getElementById("price");
        priceEl.innerText = image.price + "$";

        const creation_dateEl = document.getElementById("creation_date");
        creation_dateEl.innerText = "Created at " + image.creation_date;

        const seller_nameEl = document.getElementById("seller_name");
        seller_nameEl.innerText = image.seller_name;

        const coll_nameEl = document.getElementById("coll_name");
        coll_nameEl.innerText = image.coll_name;

        const coll_descriptionEl = document.getElementById("coll_description");
        coll_descriptionEl.innerText = image.coll_description;

        const img_descriptionEl = document.getElementById("img_description");
        img_descriptionEl.innerText = image.img_description;

        // comments
        const commentsTitleEl = document.getElementById("comments-title");
        if (comments.length) {
            commentsTitleEl.style.display = "none"
        }

        const commentsListEl = document.getElementById("comments-list");
        comments.forEach((comment) => {
            const commentContainerEl = document.createElement("div");
            commentContainerEl.classList.add("image-information-view__comment-container");

            const commentAuthorImgEl = document.createElement("img");
            commentAuthorImgEl.classList.add("image-information-view__comment-author-image");
            commentAuthorImgEl.alt = comment.author;
            commentAuthorImgEl.src = "/" + comment.author_img;

            const commentContentEl = document.createElement("div");
            commentContentEl.classList.add("image-information-view__comment-content");

            const commentAuthorEl = document.createElement("p");
            commentAuthorEl.classList.add("image-information-view__comment-author");
            commentAuthorEl.innerHTML = `
                ${comment.author}
                <span class="image-information-view__comment-date">${comment.date}</span>
            `;

            const commentTextEl = document.createElement("p");
            commentTextEl.classList.add("image-information-view__comment-text");
            commentTextEl.innerText = comment.comment;

            commentContentEl.appendChild(commentAuthorEl);
            commentContentEl.appendChild(commentTextEl);

            commentContainerEl.appendChild(commentAuthorImgEl);
            commentContainerEl.appendChild(commentContentEl);

            commentsListEl.appendChild(commentContainerEl);
        });
    };

    getInformation();
    getRecommendations();
</script>
@endsection
