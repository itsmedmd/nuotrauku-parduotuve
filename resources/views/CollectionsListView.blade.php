<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="images/favicon.ico" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <link rel="stylesheet" href="{{ asset('css/images-for-sale-list-view.css') }}">
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            laravel: "#ef3b2d",
                        },
                    },
                },
            };
        </script>
    </head>
 
    <style>
    .crimson-text {
        color: black;
        border: 10px black;
    }
    </style>


     
@extends('layouts/layout')
@section('content')
<main class="content">
    <div class="created-images-list-new-image">
        <button
            class="button button-default-actions"
            onclick="openCreatedCollectionsListView"
        >
            <?php
                $url = "/collections/open/1";     //kai view priimineja viena nari, o ne masyva
            ?>
            <a href={{ $url }}>
                My Collections
            </a> 
    </button>
    patekimas hardcodded for user 1, norint pakeist change it in url
    </div>
    <br>
    <h4>collections list</h4>
    @include('partials._search')
    
    <br>
    
    @if (count($collections) == 0)
        <h2>There are no collections</h2>
    @endif
    @if (count($collections) > 0)
        <h2>
            Total results: {{ count($collections) }}
        </h2>

        <div class="images-for-sale__sort-container">
            <a
                class="form-submit-button images-for-sale__sorting"
                href="{{ route('sortCollectionsListAsc') }}"
            >
                Sort creation date Ascending
            </a>
            <a
                class="form-submit-button images-for-sale__sorting"
                href="{{ route('sortCollectionsListDesc') }}"
            >
                Sort creation date Descending
            </a>    
        </div>

        <br>
        <br>
        <div class="lg:grid lg:grid-cols-6 gap-4 space-y-4 md:space-y-0 mx-4">
            @foreach ($collections as $coll)
                <x-collection-card :collections="$coll" />                
            @endforeach            
        </div>
    @endif
</main>
@endsection


@section('js')
<script></script>
<div class="mt-6 p-4">
    {{-- {{$collections->links()}} --}}
</div>
@endsection
</html>
{{-- onclick="openCreatedCollectionsListView({{ $user->id }})" --}}