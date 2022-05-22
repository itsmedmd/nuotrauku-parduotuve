@extends('layouts/layout')
@section('content')
@if(session('success'))
        <div class="status-container">
            <h2 class="success">{{ session('success') }}</h2>
        </div>
@endif
<main class="content">
<div>
    <h1>Transfer Image Rights</h1>
    <form method="post" action="/submitNewOwner">
        @csrf
        <label for="user">Select user</label>
        <br> 
        <input name="imageId" type="hidden" value="{{$pictureId}}">
        <select name="userId" id="user">
            @forelse ($users as $user)
            <option value="{{$user->id}}">{{$user->username}}</option>
            @empty
            @endforelse
        </select>
        <br><br>
        <input type="submit" value="Transfer">
      </form>
      
</div>
</main>
@endsection

@section('js')
<script>
</script>
@endsection