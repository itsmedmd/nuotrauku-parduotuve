@extends('layouts/layout')
@section('content')
<main class="content">
    <div class="created-images-list-new-image">
        <button
            class="button button-default-actions"
            onclick="openCreatedCollectionsListView"
        >
            <?php
                $url = "/testas/collections/open/1";     //kai view priimineja viena nari, o ne masyva
            ?>
            <a href={{ $url }}>
                My Collections
            </a> 
    </button>
    patekimas hardcodded for user 1, norint pakeist change it in url
    </div>
    <br>
    <h1>collections list</h1>

</main>
@endsection

@section('js')
<script>
</script>
@endsection

{{-- onclick="openCreatedCollectionsListView({{ $user->id }})" --}}