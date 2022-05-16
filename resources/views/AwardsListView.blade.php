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
    <h4>Awards list</h4>
    <br>
    @if (count($awards) == 0)
        <h2>There are no awards</h2>
    @endif
    @if (count($awards) > 0)
        <h2>
            Total results: {{ count($awards) }}
        </h2>        
        <br>
        <div class="lg:grid lg:grid-cols-6 gap-4 space-y-4 md:space-y-0 mx-4">
            @foreach ($awards as $aw)
                <x-card>
                    <div class="flex">
                        <div>
                            <h3 class="text-2xl">
                                {{$aw->id}}
                            </h3>
                            <div class="text-xl font-bold mb-4">{{$aw->date}}</div>
                            <div class="text-xlmb-4">{{$aw->prize}} $</div>  
                            <div class="text-xlmb-4">
                                <img
                                    src="{{ asset($aw->img_url) }}"
                                    alt="{{ $aw->title }}"
                                >
                                {{ $aw->title }}
                            </div>  
                        </div>                            
                    </div>
                </x-card>                    
            @endforeach            
        </div>
    @endif
</main>
@endsection


@section('js')
<script>
</script>
{{-- <div class="mt-6 p-4">
    {{$awards->links()}}
</div> --}}
@endsection
</html>