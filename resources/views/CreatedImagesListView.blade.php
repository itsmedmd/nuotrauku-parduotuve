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
    <!-- <h2>Successfully created new image!</h2> -->
    <div class="created-images-list-container">
        <ul class="created-images-list">
            <li class="created-images-list-item">
                <img
                    src="{{ asset('images/nft-4.jpg') }}"
                    alt="Image name 1"
                    class="created-images-list-image"
                >
                <button class="button button-default-actions" onclick="editImageInformation()">
                    Edit
                </button>
                <button class="button button-default-actions" onclick="submitImageDelete()">
                    Delete
                </button>
                <p class="created-images-list-item-name">Free Sun cancer! NO SCAM!! CALL NOW!!!</p>
            </li>
            <li class="created-images-list-item">
                <img
                    src="{{ asset('images/nft-1.jpg') }}"
                    alt="Image name 1"
                    class="created-images-list-image"
                >
                <button class="button button-default-actions" onclick="editImageInformation()">
                    Edit
                </button>
                <button class="button button-default-actions" onclick="submitImageDelete()">
                    Delete
                </button>
                <p class="created-images-list-item-name">The weeder. Edition N. 137</p>
            </li>
            <li class="created-images-list-item">
                <img
                    src="{{ asset('images/nft-2.png') }}"
                    alt="Image name 2"
                    class="created-images-list-image"
                >
                <button class="button button-default-actions" onclick="editImageInformation()">
                    Edit
                </button>
                <button class="button button-default-actions" onclick="submitImageDelete()">
                    Delete
                </button>
                <p class="created-images-list-item-name">Zucc</p>
            </li>
            <li class="created-images-list-item">
                <img
                    src="{{ asset('images/nft-3.png') }}"
                    alt="Image name 3"
                    class="created-images-list-image"
                >
                <button class="button button-default-actions" onclick="editImageInformation()">
                    Edit
                </button>
                <button class="button button-default-actions" onclick="submitImageDelete()">
                    Delete
                </button>
                <p class="created-images-list-item-name">The king of the jungle</p>
            </li>
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

    const editImageInformation = () => {
        console.log("edit");
        window.location.href = "/ImageInformationEditView";
    };

    const submitImageDelete = () => {
        console.log("delete");
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