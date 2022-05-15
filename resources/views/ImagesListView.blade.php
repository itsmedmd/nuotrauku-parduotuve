@section('styles')
<link rel="stylesheet" href="{{ asset('css/images-for-sale-list-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')

<main class="content">
    @if (count($images) == 0)
        <h2>There are no images for sale</h2>
    @endif
    @if (count($images) > 0)
        <div class="images-for-sale__forms">
            <form class="images-for-sale__search" action="submitImageSearch" method="get">
                <input
                    type="text"
                    name="text"
                    class="images-for-sale__search-input"
                    required
                    placeholder="Title, description or collection"
                >
                <input
                    class="form-submit-button images-for-sale__search-button"
                    type="submit"
                    value="Search"
                />
            </form>
        </div>
        <div class="images-for-sale__sort-container">
            <a
                class="form-submit-button images-for-sale__sorting"
                href="{{ route('sortImageListAsc', ['text' => app('request')->input('text')]) }}"
            >
                Sort Price Ascending
            </a>
            <a
                class="form-submit-button images-for-sale__sorting"
                href="{{ route('sortImageListDesc', ['text' => app('request')->input('text')]) }}"
            >
                Sort Price Descending
            </a>    
        </div>
        <div>
            <p class="images-for-sale__image-count">
                Total results: {{ count($images) }}
            </p>
            <div class="images-for-sale__images-list">
                @foreach($images as $img)
                    <a
                        class="images-for-sale__card"
                        href="{{ route('imageInformationView', ['id' => $img->id]) }}"
                    >
                        <img
                            src="{{ asset($img->img_url) }}"
                            alt="{{ $img->title }}"
                            class="images-for-sale__card-image"
                        >
                        <div class="images-for-sale__card-content">
                            <b><span class="images-for-sale__card-price">{{ $img->price }}$</span></b>
                            <span class="images-for-sale__card-title">{{ $img->title }}</span>
                            <p class="images-for-sale__card-rating">Rating: {{$img->rating}}</p>
                            <p class="images-for-sale__card-collection">Collection: <b>{{ $img->collection }}</b></p>
                            <p class="images-for-sale__card-description">{{ $img->img_description }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</main>
@endsection

@section('js')
<script>
</script>
@endsection