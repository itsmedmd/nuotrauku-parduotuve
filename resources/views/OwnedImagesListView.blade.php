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
  
  </style>

<main class="content">
    User Id - {{ $userId }}
    <h1>Owned Images</h1>
    <table>
        <tr>
            <th style="width:30%">
            </th>
            <th>
                Title
            </th>
            <th>
                Current Collection
            </th>
            <th>
                Change Collection to...
            </th>
        </tr>
        @forelse ($images as $img)
        <?php
            $coll = DB::select('SELECT * FROM collections WHERE id = ?', [$img->fk_user_id_savininkas]);
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
                <th>
                    @foreach($collections as $collection)
                        <a href="">{{$collection->name}}</a>
                    @endforeach
                </th>
            </tr>
        @empty
            No images owned
        @endforelse
    </table>
</main>
@endsection

@section('js')
<script>



</script>
@endsection