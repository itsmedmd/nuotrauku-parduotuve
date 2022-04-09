<?php
    use App\Http\Controllers\ImagesManagementSubsystemController;
?>

@section('styles')
<link rel="stylesheet" href="{{ asset('css/created-images-list-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<!-- <div class="action-confirmation-form-overlay">
    <div class="action-confirmation-form-overlay-content">
        <p class="action-confirmation-form-text">
            Do you really want to delete the image?
        </p>
        <div class="action-confirmation-form-buttons">
            <button class="button action-confirmation-form-confirm">
                Confirm
            </button>
            <button class="button action-confirmation-form-cancel">
                Cancel
            </button>
        </div>
    </div>
</div> -->
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
                            Edit
                        </button>
                        <button
                            class="button button-default-actions"
                            onclick="submitImageDelete({{ $img->id }})"
                        >
                            Delete
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
        console.log("create");
        window.location.href = "/ImageCreationView";
    };

    const editImageInformation = (id) => {
        console.log("edit", id);
        //window.location.href = "/ImageInformationEditView";
    };

    const submitImageDelete = (id) => {
        console.log("delete", id);
    };
</script>
@endsection

<!-- <script>
    const csrfToken = '{{csrf_token()}}';

    // "$" comes from jquery (imported in layout file)
    const doSomething = () => {
        $.post('{{route('TESTdoSomething')}}', { _token: csrfToken }, function (data) {
            console.log("all received data: ", data);

            if (data.status === "error") {
                console.log("error! message from data: ", data.message);
            } else{
                console.log("success!");
            }
        });
    }; 
</script> -->