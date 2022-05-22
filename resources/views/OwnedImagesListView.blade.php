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
@php
    use App\Http\Controllers\UserManagementSubsystemController;
@endphp
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
                    <?php
                    $url = "/OwnedImageInformationView/".$img->id;     //kai view priimineja viena nari, o ne masyva
                 ?>
                    <a href={{ $url }}>
                        {{ $img->title }}
                    </a> 
                </th>
                <th>
                    <p>
                        @foreach($coll as $c)
                            <p>{{$c->name}}</p>
                        @endforeach
                    </p>
                </th>
                <th>
                    <p>
                        <form action="/images/sellwindow/{{ $userId }}/{{ $img->id }}">
                            <input type="submit" value="Sell">
                        </form>
                    </p>
                </th>
                <th>
                    <p>
                        <form action="/ImageRightsTransferView/{{ $userId }}/{{ $img->id }}">
                            <input type="submit" value="Transfer Rights">
                        </form>
                    </p>
                </th>
                <th>
                    <p>
                        <form action="/purchaseinformation/{{ $img->id }}/{{ $userId }}/0">
                        <?php
                            $wasSold = DB::table('bills')
                            ->where('fk_image_id', $img->id)
                            ->get();
                            $show = $exists = sizeof($wasSold);
                        ?>
                            <h1><?php if($show) : ?>
                                <input type="submit" value="Purchase Info">
                                <?php endif; ?>
                            </h1>
                        </form>
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
        
      <br>
     


</main>
@endsection

@section('js')
<script>

</script>
@endsection