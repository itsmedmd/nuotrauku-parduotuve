@extends('layouts/layout')
@section('content')

<style>
    input {      
      width: 100px;
    }
</style>

<main class="content">
    <h1>owned image information</h1>
    <img src="{{ asset($image->image) }}" alt="loading..." width="400" height="300"><br>
    <br>
    Title - {{ $image->title }} 
    <br>
    And so on...
    <br>
    Visibility - {{ $image->is_visible }} 
    <br>

    <?php
        $url = '/OwnedImageInformationView/'.$image->id;
    ?>
    <form action="{{url($url)}}" method="post">
        @csrf
       <input type="submit" value="Change Visibility">
    </form>


</main>
@endsection

@section('js')
<script>
</script>
@endsection