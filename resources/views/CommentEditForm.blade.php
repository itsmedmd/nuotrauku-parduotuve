@extends('layouts/layout')
@section('content')

<style>
    input[type=submit] {
        width: 50px;
    }
</style>

@if(session('status'))
    <div class="status-container">
        <h2 class="success">{{ session('status') }}</h2>
    </div>
@endif

<main class="content">
    <h1>Comment edit</h1>
    <br>
    <form action="{{ route('editComment')}}" method="post">
        @csrf
        <input name="id" id="id" type="hidden" value="{{$comment->id}}">
            <div>
                Comment:  <input type="text" name="commentValue" maxlength="500" value="{{$comment->comment}}" required /><br/>
            </div>
                <input type="submit" name="submit" value="Edit" />
        </div>
    </form>
</main>
@endsection

@section('js')
<script>
</script>
@endsection