@section('styles')
<link rel="stylesheet" href="{{ asset('css/image-information-edit-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<main class="content image-information-edit-view">
    <div class="image-information-edit-image-container">
        <img
            src="{{ asset('images/nft-2.png') }}"
            alt="Image name 2"
            class="image-information-edit-image"
        >
    </div>
    <div class="form-wrapper">
        <h2 class="form-title">Edit image information</h2>
        <!-- <h4>* The title must not be empty.</h4> -->
        <form method="post">
            <div>
                <label for="title">Title:</label><br>
                <input name="title" id="title" type="text" maxlength="200" required value="Zucc">
            </div>	
            <div>
                <label for="description">Description:</label><br>
                <input name="description" id="description" type="text" maxlength="500" value="Zucc is the richest">
            </div>	
            <div>
                <label for="price">Price:</label><br>
                <input name="price" id="price" type="number" min="0" step="0.01" value="1337">
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