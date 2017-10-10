@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading"><strong>Send Bitcoin</strong> (belongs to Coinbase Master a/c)</div>

                <div class="panel-body">
                    Receiving BTC Address: <strong>{{ $currentReceiveAddress }}</strong>
                </div>

            </div>
        </div>
    </div>

     <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading"><strong>QR Code</strong> (belongs to Coinbase Master a/c)</div>

                    <div class="panel-body">
                        QR Code : <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $currentReceiveAddress }}&amp;size=150x150" alt="" title="" />
                    </div>
            </div>
        </div>
    </div>

    <div class="row">
       <div class="col-md-8 col-md-offset-2">
           <div class="panel panel-info">
               <div class="panel-heading">
                <strong>******************************** OR Send funds directly from your wallet ********************************</strong>
               </div>
           </div>
       </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading"><strong>Send Bitcoin</strong> (belongs to Coinbase Master a/c)</div>

                <div class="panel-body">
                    <div class="panel-body">
                        Receiving BTC Address: {{ $currentReceiveAddress }}
                    </div>
                    <div class="row">
                        <a href="{{ route('BTCsendForm', [ "currentReceiveAddress" => $currentReceiveAddress ]) }}" class="btn btn-success">
                            Send Bitcoin from my Wallet
                        </a>
                        (amount set to 5 USD + transaction fee)
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
