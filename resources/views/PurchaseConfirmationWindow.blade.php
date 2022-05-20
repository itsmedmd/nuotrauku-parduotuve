@extends('layouts/layout')
@section('content')
<main class="content">
    <br>
<?php if($action == 10) : ?>
    <br>
    <p style="color:green">Purchase Successful</p>
    <br>
<?php endif; ?>
<?php if($action == 11) : ?>
    <br>
    <p style="color:red">Not enough moneys in wallet</p>
    <br>
<?php endif; ?>
<img src="{{ asset($image->image) }}" alt="kazkas" width="200" height="150"><br>
<p>Title: {{$image->title}}</p><br>
<p>Price: {{$image->price}}</p><br>


<?php if($action == 1) : ?>
    <br>
    <form action="/purchaseConfirmation/{{ $image->id}}/{{ $userId  }}/1">
        <input style="width:150px" type="submit" value="Confirm Purchase">
    </form>
    <br>
<?php endif; ?>

</main>
@endsection

@section('js')
<script>
</script>
@endsection