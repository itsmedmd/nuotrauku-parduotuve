@extends('layouts/layout')
@section('content')
<main class="content">
    @if (count($images) == 0)
        <h2>There are no images for sale</h2>
    @endif
    <ul>
        @foreach($images as $img)
            <p>{{ $img->price }} {{ $img->fk_image_id }}</p>
        @endforeach
    </ul>
</main>
@endsection

@section('js')
<script>
</script>
@endsection