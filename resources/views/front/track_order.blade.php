@extends('layouts.app')
@section('title', 'Track Order')

@section('content')

<div id="trackoder">
    <div class="container mb">
        <section class="breadcrumbs ">
            <ul class="uk-breadcrumb">
                <li><a href="{{ route('home.index') }}">Home</a></li>
                <li><span>Track Order</span></li>
            </ul>
        </section>
        <div class="row">
            <div class="col-md-6 offset-md-3 box-shadow p-2" style="background:#fff;padding:20px !important; margin-bottom:20px;">
                <form action="{{route('track_no')}}" method="post">
                    {{csrf_field()}}
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend">
                            To track your order please enter your Order ID in the box below and press the "Track" button.
                            This was given to you on your receipt and in the confirmation email you should have received.
                        </legend>

                        @if(isset($order))
                        @php
                            $one = 100 / 7;
                            switch($order->orderStatus->name) {
                                case 'pending':
                                    $percent = $one;
                                    break;
                                case 'received':
                                    $percent = $one * 2;
                                    break;
                                case 'approved':
                                    $percent = $one * 4;
                                    break;
                                case 'delivered':
                                    $percent = $one * 6;
                                    break;
                                case 'review':
                                    $percent = $one * 3;
                                    break;
                                case 'dispatched':
                                    $percent = $one * 5;
                                    break;
                                case 'completed':
                                    $percent = $one * 7;
                                    break;
                                default:
                                    $percent = 0;
                            }
                            
                        @endphp
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-4" style="color:#403f3f;width: {{ number_format($percent, 2) }}%">{{ number_format($percent, 2) }}% {{ $order->orderStatus->name}}</div>
                            </div>
                        </div>
                        @endif

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">Order Number</label>
                            <input class="uk-input" name="order_code" id="form-stacked-text" type="text" placeholder="Found in your order confirmation email.">
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text2">Billing email</label>
                            <input class="uk-input" id="form-stacked-text2" type="text" value="{{ Auth::user()->email }}" disabled>
                        </div>

                        <button type="submit" class="uk-button btn-success" style="font-weight:500;width:100%;border-radius:2px;box-shadow:0 2px 4px 0 rgba(0,0,0,.23);">track</button>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')

@endsection
