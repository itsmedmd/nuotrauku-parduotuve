<?php
    use App\Http\Controllers\ImagesSubsystemController;
?>

@extends('layouts/layout')
@section('content')
<main class="content">
    home
    <div>
        <button onclick="doSomething()">
        get json value from controller method (open browser console to view)
        </button>
    </div>
</main>
@endsection

@section('js')
<script>
    const csrfToken = '{{csrf_token()}}';

    // "$" comes from jquery (imported in layout file)
    const doSomething = () => {
        $.post('{{route('TESTdoSomething')}}', { _token: csrfToken }, function (data) {
            console.log("all received data: ", data);

            if (data.status === "error") {
                console.log("error! message from data: ", data.message);
            } else{
                console.log("success!");
            }
        });
    };
</script>
@endsection