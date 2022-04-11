@section('styles')
<link rel="stylesheet" href="{{ asset('css/image-information-edit-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<main class="content image-information-edit-view">
    <div class="image-information-edit-image-container">
        <img
            src="{{ asset($image->image) }}"
            alt="{{$image->title}}"
            class="image-information-edit-image"
        >
    </div>
    <div class="form-wrapper">
        <h2 class="form-title">Edit image information</h2>
    
        @if ($errors->any())
            <div class="status-container">
                @foreach ($errors->all() as $error)
                    <h4 class="error">* {{ $error }}</h4>
                @endforeach
            </div>
        @endif

        <form method="post" action="{{ route('submitNewImageData') }}">
            @csrf
            <input name="id" type="hidden" value="{{$image->id}}">
            <div>
                <label for="title">Title:</label><br>
                <input name="title" id="title" type="text" maxlength="200" required value="{{$image->title}}">
            </div>	
            <div>
                <label for="description">Description:</label><br>
                <input name="description" id="description" type="text" maxlength="500" value="{{$image->description}}">
            </div>	
            <div>
                <label for="price">Price:</label><br>
                <input name="price" id="price" type="number" min="0" step="0.01" value="{{$image->price}}">
            </div>	
            <div>
                <input type="submit" name="new_image_form" value="Edit" class="form-submit-button">
            </div>
        </form>
    </div>
</main>
@endsection

@section('js')
<script>
</script>
@endsection