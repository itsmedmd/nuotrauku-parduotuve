@extends('layouts/layout')
@section('content')

<style>
    input {      
      width: 100px;
    }
</style>
<?php $url = "/testas/collection/create/".$userId."/text/dexcriptionnnn"?>
<main class="content image-information-edit-view">
    <div class="form-wrapper">
        <h2 class="form-title">Create new collection({{$userId}})</h2>
        <form action="{{url($url)}}" method="post">
            @csrf
            <div>
                <label for="title">New collection name:</label><br>
                <input name="title" id="name" type="text">
            </div>	
            <div>
                <label for="description">Description:</label><br>
                <input name="description" id="description" type="text" maxlength="500">
            </div>
            <div>
                <input type="submit" value="Create">
            </div>
        </form>
    </div>
</main>
@endsection

@section('js')
<script>
</script>
@endsection