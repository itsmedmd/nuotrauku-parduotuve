<?php
    use App\Http\Controllers\ImagesManagementSubsystemController;
?>

@section('styles')
<link rel="stylesheet" href="{{ asset('css/created-images-list-view.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<main class="content">
    Created images list:
    <div>
        <button onclick="openImageCreationView()">
            Create New Image
        </button>
    </div>
    <div class="created-images-list">
        <ol>
            <li>
                <img src="" alt="Image name 1">
                <p>Image name 1</p>
                <button onclick="editImageInformation()">
                    Edit
                </button>
                <button onclick="submitImageDelete()">
                    Delete
                </button>
            </li>
            <li>
                <img src="" alt="anotha Image name">
                <p>anotha Image name</p>
                <button onclick="editImageInformation()">
                    Edit
                </button>
                <button onclick="submitImageDelete()">
                    Delete
                </button>
            </li>
        </ol>
    </div>
</main>
@endsection

@section('js')
<script>
    const openImageCreationView = () => {
        console.log("create");
    };

    const editImageInformation = () => {
        console.log("edit");
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