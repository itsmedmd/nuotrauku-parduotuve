@extends('layouts/layout')
@section('content')

<style>
    table {
      font-family: arial, sans-serif;
      
      width: 100%;
    }

    a {
      color: blue;
    }
    
    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
        
    tr:nth-child(even) {
      background-color: #dddddd;
    }
</style>

<main class="content">
    <h1>
        My Collections ({{$userId}})
    </h1>
    <br>
    <table>
        <tr>
            <th colspan="4">Collection name </th>

          </tr>
        @forelse ($collections as $collection)
        <tr>
            <td>{{ $collection->name }}</td>
            <th>
              <?php $urlInfo ="/collections/".$userId."/".$collection->id?>
              <a href={{ $urlInfo }}>
                  Info
              </a>
          </th>
            <th>
              <?php $urlEdit2 = "/testas"?>
              <?php $urlEdit = "/testas/collections/openEdit/".$userId."/".$collection->id."/".$collection->name."/".$collection->description?>
              <a href={{ $urlEdit }}>
                  Edit
              </a>
            </th>
            <th>
                <?php $urlDelete ="/testas/collections/delete/".$userId."/".$collection->id?>
                <a href={{ $urlDelete }}>
                    Delete
                </a>
            </th>
          </tr>
        @empty
        <p>No collections created</p>
        @endforelse
        <?php $urlNew = "/testas/collections/create/".$userId;?>
        <a href={{ $urlNew }}>Create New</a>
        <br>
    </table>
</main>
@endsection

@section('js')
<script>
</script>
@endsection