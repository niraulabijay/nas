@extends('layouts.app')
@section('title', 'Disputes')

@section('content')
    @include('partials.message-error')
    @include('partials.message-success')

    <div class="container">
        <div class="return-product-div">
            <div class="row crows">
                <div class="col-md-10">
                    <div class="row crows">
                        <div class="col-sm-5">
                            <div class="return-product-image">
                                <img src="{{ asset(getProductImage($order_product_id->product_id, 'medium')) }}">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="product--reveal__right">
                                <div class="product--header">
                                    <div class="product__title bold">
                                        <span>{{$order_product_id->products->product_name}}</span>
                                    </div>

                                </div>
                                <div class="product--details product--details--return">
                                    <ul class="liststyle--none">
                                        <li><span class="bold">Sold by : </span><span class="link-2 text-danger bold">Gold Star</span>
                                        </li>
                                        <li><span class="bold">Shipped : </span><span
                                                    class="link">March 3,2018</span></li>

                                    </ul>
                                </div>
                                <form action="{{ route('dispute.message.save') }}" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" value="{{$order_product_id->id}}" name="order_product_id" />
                                    <div class="product--description__title bold return-product-topic">
                                        <span>Why are you returning this?</span>
                                        <p>
                                            <select class="form-control" name="topic_id">
                                                @foreach($topic as $topic)
                                                    <option value="{{$topic->id}}">{{$topic->topic}}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    </div>
                                    <div class="from-group {{ $errors->has('return_message') ? ' has-error' : '' }}">
                                        <div class="product--details product--details--return">
                                            <ul class="liststyle--none">
                                                <li><span class="bold">Your Reason * </span>
                                                </li>
                                                <textarea class="form-control" rows="5" cols="100" id="comment" name="return_message" required></textarea>
                                            </ul>
                                        </div>
                                        @if ($errors->has('return_message'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('return_message') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="product--details product--details--return">
                                        <input type="submit" value="send" class="btn btn-primary pull-right">
                                    </div>
                                </form>
                                <div class="product--details product--details--return">
                                    <ul class="liststyle--none">
                                        <li><strong style="font-size: 16px;">Note:</strong>
                                            <span class=""> Please post your valid/genuine reason for your dispute.
                                                Once owner has approved your reason, you can talk to seller about your complain.
                                                Sorry for inconvenience.
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection