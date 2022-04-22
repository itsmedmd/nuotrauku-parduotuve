@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@extends('layouts/layout')
@section('content')
<main class="content homepage">
    <div class="home-background-color"></div>
    <h1 class="home-title">
        Dive into a world you haven't experienced before - <br>
        the world of <span class="home-title-cool">digital images</span>
    </h1>
    <!-- home
    <div>
        <button onclick="doSomething()">
        get json value from controller method (open browser console to view)
        </button>
    </div> -->
</main>
@endsection

@section('js')
<script>
    // const csrfToken = '{{csrf_token()}}';

    // // "$" comes from jquery (imported in layout file)
    // const doSomething = () => {
    //     $.post('{{route('TESTdoSomething')}}', { _token: csrfToken }, function (data) {
    //         console.log("all received data: ", data);

    //         if (data.status === "error") {
    //             console.log("error! message from data: ", data.message);
    //         } else{
    //             console.log("success!");
    //         }
    //     });
    // };
</script>
@endsection