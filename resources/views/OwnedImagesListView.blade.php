@extends('layouts/layout')
@section('content')

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

  select {
    width: 300px;
  }

  input {
    width: 100px;
  }

  
  </style>

<main class="content">
    User Id - {{ $userId }}
    <h1>Owned Images</h1>
    <table>
        @forelse ($images as $img)
        <?php
            $coll = DB::select('SELECT * FROM collections WHERE id = ?', [$img->fk_collection_id_dabartine]);
        ?>
            <tr>
                <th style="width:30%">
                    <img src="{{ asset($img->image) }}" alt="kazkas" width="100" height="100">
                </th>
                <th>
                    <p>{{ $img->title }}</p>
                </th>
                <th>
                    <p>
                        @foreach($coll as $c)
                            <p>{{$c->name}}</p>
                        @endforeach
                    </p>
                </th>
            </tr>
        @empty
            No images owned
        @endforelse
    </table>

    <br>
    <h3>Move picture to collection...</h3>
    <form action="/ownedimages/movetocollection/{{ $userId }}">
        <label for="cars">Picture to move:</label>
        <br> 
        <select name="picId" id="titles">
            @forelse ($images as $img)
            <option value="{{$img->id}}">{{$img->title}}</option>
            @empty
            <option>--No images owned--</option>
            @endforelse
        </select>
        <br>   
        <label for="cars">To collection:</label> 
        <br> 
          <select name="collId" id="collections">
            @forelse ($collections as $collection)
            <option value="{{$collection->id}}">{{$collection->name}}</option>
            @empty
                <option>--No collections owned--</option>
            @endforelse
        </select>
        <br><br>
        <input type="submit" value="Move">
      </form>
      <p style="color:green; font-size:12px;">{{ $msg }}</p>




</main>
@endsection

@section('js')
<script>



</script>
@endsection