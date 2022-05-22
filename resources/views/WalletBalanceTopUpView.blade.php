@extends('layouts/layout')
@section('content')

<main class="content">
@php
use App\Http\Controllers\UserManagementSubsystemController;
@endphp
@if($successTopUp)
        <div class="status-container">
            <h2 class="success">{{ $successTopUp }}</h2>
        </div>
@endif
    <div>
        <h1>TOP UP SUM</h1>
        <form method="post" action="{{ route('submitTopUpValue') }}">
            @csrf
            <input name="id" type="hidden" value="{{$item->id}}">
        <div>
            <input name="price" id="price" type="number" min=0 step=0.01 required>
        </div>
        <div>
            <input type="submit" value="TOPUP" class="button-default-actions" />
        </div>
        </form>
    </div>
</main>
@endsection

@section('js')
<script>
</script>
@endsection