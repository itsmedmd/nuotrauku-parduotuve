@extends('layouts/layout')
@section('content')

<style>
    input[type=submit] {
        width: 50px;
    }
</style>

<main class="content">
    <h1>User{{$userId}}</h1>
    <br>
    <?php $url2 = "/collections/create/new/".$userId;?>
    <form action={{$url2}} method="get">
        <div>
            Name:  <input type="text" name="collectionName" maxlength="100" required /><br/>
        </div>
        <div>
            Description: <input type="text" name="description" maxlength="500" required /><br/>
        </div>
            <input type="submit" name="submit" value="Create" />
        </div>
    </form>
    
</main>
@endsection

@section('js')
<script>
</script>
@endsection