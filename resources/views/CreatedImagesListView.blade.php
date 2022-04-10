@section('styles')
<link rel="stylesheet" href="{{ asset('css/created-images-list-view.css') }}">
@endsection

@extends('layouts/layout')

@section('content')
@if (session('openActionConfirmationForm') == true)
<x-action-confirmation-form
    message="Do you really want to delete the image?"
    origin="CreatedImagesListView"
    action="deleteCreatedImage"
    itemID="{{session('itemID')}}"
/>
@endif
<main class="content">
    <h1 class="page-title">Created Images List</h1>
    <div class="created-images-list-new-image">
        <button class="button" onclick="openImageCreationView()">
            Create New Image
        </button>
    </div>
    @if(session('success-status'))
        <div class="status-container">
            <h2 class="success">{{ session('success-status') }}</h2>
        </div>
    @endif
    <div class="created-images-list-container">
        @if (count($images) == 0)
            <h2>There are no created images</h2>
        @endif
        <ul class="created-images-list">
            @foreach($images as $img)
                <li class="created-images-list-item">
                    <img
                        src="{{ asset($img->image) }}"
                        alt="{{ $img->title }}"
                        class="created-images-list-image"
                    >
                    @if ($img->fk_user_id_savininkas == $img->fk_user_id_kurejas)
                        <button
                            class="button button-default-actions"
                            onclick="editImageInformation({{ $img->id }})"
                        >
                            <a href="{{ route('editImageInformation', ['id' => $img->id]) }}">
                                Edit
                            </a> 
                        </button>
                        <button class="button button-default-actions">
                            <a href="{{ route('submitCreatedImageDelete', ['id' => $img->id]) }}">
                                Delete
                            </a> 
                        </button>
                    @endif
                    <p class="created-images-list-item-name">{{ $img->title }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</main>
@endsection

@section('js')
<script>
    const openImageCreationView = () => {
        window.location.href = "/ImageCreationView";
    };
</script>
@endsection
