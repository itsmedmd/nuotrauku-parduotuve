@extends('layouts/layout')
@section('content')
<main class="content">
    <h1>{{ $collection->name }}</h1><br><br>
    <p>Description: {{ $collection->description }}</p>
    <p>Creator: {{$username}}</p>
    <p>Creation Date: {{ $collection->creation_date }}</p>
</main>
@endsection

@section('js')
<script>
</script>
@endsection