@extends('layouts/layout')

@php
    use App\Http\Controllers\UserManagementSubsystemController;
@endphp

@section('content')
<main class="content">
@if(session('success-status'))
        <div class="status-container">
            <h2 class="success">{{ session('success-status') }}</h2>
        </div>
@endif
<h3>Wallet balance: {{$item->wallet_balance}}$</h3>

<button class="button button-default-actions">
    <a href="{{ route('WalletBalanceTopUpView', ['id' => $item->id]) }}">Top Up Wallet</a> 
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