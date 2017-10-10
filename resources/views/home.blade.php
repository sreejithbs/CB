@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">Logged User Details</div>

                <div class="panel-body">
                    Name: <strong>{{ $currentUser->name }}</strong>
                </div>
                <div class="panel-body">
                    Email : <strong>{{ $currentUser->email }}</strong>
                </div>
                <div class="panel-body">
                    Bitcoin Wallet Name : <strong>{{ $currentUser->bitcoinWalletName }}</strong>
                </div>
                <div class="panel-body">
                    Bitcoin Wallet ID : <strong>{{ $currentUser->bitcoinWalletID }}</strong>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <button class="btn btn-default">
                <a href="{{ route('createAddress', [ "walletID" => $currentUser->bitcoinWalletID ]) }}">
                    Add New Address
                </a>
            </button>
        </div>

        <div class="col-md-2">
            <button class="btn btn-default">
                <a href="{{ route('sendBTC') }}">
                    Send Funds
                </a>
            </button>
        </div>

    </div>
<br>

     <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">Associated Addresses corresponding to Wallet ID : <strong>{{ $currentUser->bitcoinWalletID }}</strong></div>

                @foreach($btcaddresses as $singleAddress)
                    <div class="panel-body">
                        Addrees No {{ $loop->iteration }} : <strong>{{ $singleAddress->address }}</strong>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
