@extends('layouts/layout')

@php
    use App\Http\Controllers\UserManagementSubsystemController;
@endphp

@section('content')
<main class="content">

    
<h3>{{$item->wallet_balance}}</h3>

<button class="button button-default-actions">
    <a href="{{ route('WalletBalanceTopUpView', ['id' => $item->id]) }}">Information</a> 
</button>

</main>
@endsection

@section('js')
<script>
    const openWalletTopUpView = () => {
        window.location.href = "/WalletBalanceTopUpView";
    };
</script>
@endsection