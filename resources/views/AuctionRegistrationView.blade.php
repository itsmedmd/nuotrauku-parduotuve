@section('styles')
<link rel="stylesheet" href="{{ asset('css/image-creation-view.css') }}">
@endsection

@php
use App\Http\Controllers\AuctionsSubsystemController;
@endphp

@extends('layouts/layout')
@section('content')
<main class="content image-creation-view">
    <div class="form-wrapper">
        <h2 class="form-title">Create new auction</h2>

        @if ($errors->any())
            <div class="status-container">
                @foreach ($errors->all() as $error)
                    <h4 class="error">* {{ $error }}</h4>
                @endforeach
            </div>
        @endif

        <form method="post" enctype="multipart/form-data" action="{{ route('createNewAuction') }}">
            @csrf
            <div>
                <label for="end_date">End date:</label><br>
                <input name="end_date" id="end_date" type="datetime-local" required>
            </div>	
            <div>
                <input name="fk_image_id" type="hidden" value=0>
                <label for="fk_image_id">Image</label><br>
                <select name="fk_image_id" id="fk_image_id" required>
                    @foreach($avaivableImageNames as $avaivableImageName)
                        <option value="{{ $avaivableImageName->id }}">{{ $avaivableImageName->title }}</option>
                    @endforeach
                    
                </select>

                @if (count($avaivableImageNames) != 00)
                <h2>Rekomenduojama kaina aukcionui: {{AuctionsSubsystemController::displayRecomendedPrice($avaivableImageName->fk_user_id_savininkas);}}</h2>
                @endif
                
            </div>	
            <div>
                <label for="price">Price:</label><br>
                <input name="price" id="price" type="number" min="0" step="0.01" required>
            </div>	
            <div>
                <label for="minimum_bid_raise">Minimum bid)</label><br>
                <input name="minimum_bid_raise" id="minimum_bid_raise" type="number" min="0" step="0.01" required>
            </div>	
            <div>
                <input type="submit" name="new_image_form" value="Create" class="form-submit-button">
            </div>
        </form>
    </div>
</main>
@endsection
