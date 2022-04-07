@section('styles')
<link rel="stylesheet" href="{{ asset('css/image-creation-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<main class="content image-creation-view">
    <div class="form-wrapper">
        <h2 class="form-title">Create new image</h2>
        <h4>* Title must not exceed 200 characters.</h4>
        <form method="post">
            <div>
                <label for="title">Title:</label><br>
                <input name="title" id="title" type="text" maxlength="200" required>
            </div>
            <div>
                <label for="image">Image file:</label><br>
                <input  id="image" name="image" type="file" placeholder="Choose image" required>
            </div>	
            <div>
                <label for="description">Description (not required):</label><br>
                <input name="description" id="description" type="text" maxlength="500">
            </div>	
            <div>
                <label for="price">Price (not required):</label><br>
                <input name="price" id="price" type="number" min="0" step="0.01">
            </div>	
            <div>
                <input type="submit" name="new_image_form" value="Create" class="form-submit-button">
            </div>
        </form>
    </div>
</main>
@endsection

@section('js')
<script>
</script>
@endsection