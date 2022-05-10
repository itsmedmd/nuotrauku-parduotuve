@extends('layouts/layout')
@section('content')

<?php
    $image = DB::table('images')->find($pictureId);
?>

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 50%;
      }
      
      td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        width: 50%;
      }
      a {
          color: blue;
      }
    
      form {
        width: 300px;
      }
    

    
      
      </style>

<main class="content">

    <img src="{{ asset($image->image) }}" alt="loading picture..." width="400px" height="300px"><br>
    <b> Title - {{ $image->title }}</b>
    <p>Created at - {{ $image->creation_date }}</p>
    
    <?php $url = "/images/putforsale/".$userId."/".$pictureId;?>
    <form action={{ $url }} method="get">
        
        <div>
            <label for="price">Set price:</label><br>
            <input style="size=200px;" name="price" id="price" type="number" min="0" step="0.01" required>
        </div>

            <input type="submit" name="submit" value="Put for sale" /><p style="color:green;">{{ $msg }}</p>
        </div>

    </form>
</main>

@endsection

@section('js')
<script>
</script>
@endsection