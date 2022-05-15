@extends('layouts/layout')
@section('content')
<style>
    main {text-align: center;}
</style>

<main class="content">
    <img src="{{ asset($image->image) }}" alt="kazkas" width="200" height="150"><br>
    <h1>{{$image->title}}</h1><br><br>
    <p>Collection - {{$collection->name}}</p>
    <p>Price - {{$image->price}} moneys</p>
    <p>Creation date - {{$image->creation_date}}</p>
    <p>Owner - {{$owner->username}}</p>

</main>
@endsection

@section('js')
<script>
</script>
@endsection