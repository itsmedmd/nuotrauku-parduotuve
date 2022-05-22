@extends('layouts/layout')
@section('content')
<style>
    main {text-align: center;}
</style>

<main class="content">
    <img src="{{ asset($image->image) }}" alt="kazkas" width="200" height="150"><br>
    <h1>{{$image->title}}</h1><br><br>
    <p>Collection - {{$collection->name}}</p>
    <p>Price - {{$image->price}} moneys</p>
    <p>Creation date - {{$image->creation_date}}</p>
    <p>Owner - {{$owner->username}}</p>
    <br>
</form>
    <hr>
    <?php if($action == 20) : ?>
    <br>
    <p style="color:green">Purchase Successful</p>
    <?php endif; ?><br>
    <?php if($action == 10) : ?>
    <br>
    <p style="color:green">Purchase Successful</p>
    <?php endif; ?><br>
    
    <?php if($userId != $image->fk_user_id_savininkas) : ?>
        <p>Buy Picture</p>
        {{-- <p>{{ $userId }}</p>
        <p>{{ $image->fk_user_id_savininkas }}</p> --}}
        <table style="width:100%">
            <tr>
                <td>
                    Using Wallet
                    <br><br>
                    <form action="/purchaseWallet/{{ $image->id}}/{{ $userId  }}/1">
                        <input style="width:150px" type="submit" value="Purchase">
                      </form>
                    <br><br>
                    <?php if($action == 11) : ?>
                    <br>
                    <p style="color:red">Not enough moneys in wallet</p>
                  <?php endif; ?>
                </td>
                <td>
                    Using Credit Card
                    <br><br>
                    <form action="/purchaseBank/{{ $image->id}}/{{ $userId  }}/20">
                        <label for="fname">First name:</label><br>
                        <input ><br>
                        <label for="lname">Last name:</label><br>
                        <input ><br>
                        <label for="lname">Credit Card Number:</label><br>
                        <input ><br>
                        <label for="lname">Valid through: yy/mm</label><br>
                        <input ><br><br>
                        <input style="width:150px" type="submit" value="Submit">
                      </form>
                      <?php if($action == 20) : ?>
                        <br>
                        <p style="color:green">Purchase Successful</p>
                      <?php endif; ?>
                    </form>
                    <?php if($action == 21) : ?>
                      <br>
                      <p style="color:red">Bank confirmation error</p>
                    <?php endif; ?>
                </td>
            </tr>
          </table>
    <?php endif; ?>

</main>
@endsection

@section('js')
<script>
</script>
@endsection