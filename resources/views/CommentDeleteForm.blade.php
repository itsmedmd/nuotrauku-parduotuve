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
    Are you sure want to delete?
</main>
@endsection

@section('js')
<script>
</script>
@endsection