@extends('layouts/layout')
@section('content')

<style>
    input[type=submit] {
        width: 50px;
    }
</style>

<main class="content">
    <h1>User{{$userId}}</h1>
    <h1>Collection{{$collectionId}}</h1>
    <br>
    <?php $url = "/collections/edit/".$userId."/".$collectionId?>
    <form action={{$url}} method="get">
        <div>
            Name:  <input type="text" name="collectionName" maxlength="100" value="{{$collectionName}}" required /><br/>
        </div>
        <div>
            Description: <input type="text" name="description" maxlength="500" value="{{$collectionDescription}}" required /><br/>
        </div>
            <input type="submit" name="submit" value="Edit" />
    </div>
</main>
@endsection

@section('js')
<script>
</script>
@endsection