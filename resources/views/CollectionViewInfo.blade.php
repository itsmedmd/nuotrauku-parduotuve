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
    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/images-for-sale-list-view.css') }}">
    @endsection
    {{-- @props(['collections']) --}}
    @extends('layouts/layout')
    @section('content')  
    <div class="content mx-4">
        <x-card class="p-10">
            <div class="flex flex-col items-center justify-center text-center">
                <h3 class="text-2xl mb-2">{{$collections->name}}</h3>
                <div class="text-xl font-bold mb-4">{{$collections->creation_date}}</div>
                <div class="border border-gray-200 w-full mb-6"></div>
                <div>
                    <h3 class="text-3xl font-bold mb-4">
                        Description
                    </h3>
                    <div class="text-lg space-y-6">
                        {{$collections->description}}
                    </div>
                </div>
                <div class="border border-gray-200 w-full mb-6"></div>
                <h3 class="text-3xl font-bold mb-4">
                    Pictures
                </h3>
                <div>
                    @if (count($images) == 0)
                        <h2>There are no images for sale</h2>
                    @endif
                    @if (count($images) > 0)
                    @php($sum = 0);
                    <div class="images-for-sale__images-list">
                        @foreach($images as $img)
                            <a
                                class="images-for-sale__card"
                                href="{{ route('imageInformationView', ['id' => $img->id]) }}"
                            >
                                <img
                                    src="{{ asset($img->image) }}"
                                    alt="{{ $img->title }}"
                                    class="images-for-sale__card-image"
                                >
                                {{ $img->title }}
                            </a>
                            @php($sum += $img->rating)
              
                        @endforeach
                        
                    </div>                    
                    @endif
                </div>                
            </div>
        </x-card>
        <h1> Kolekcijos nuotrauku bendras reitingas: {{$sum}}</h1>
    </div> 
    @endsection

@section('js')
<script>
</script>
@endsection
</html>