@extends('merchant.layouts.app')
@section('title', 'Disputes')

@section('content')
    @include('partials.message-error')
    @include('partials.message-success')
    <section>
        <div class="row">
            <h3>Customer Name: </h3>
            <div class="col-xs-12 content__box content__box--shadow">
                <div class="col-xs-4">
                    <div style="width: 20%;">
                        <img src="{{ asset(getProductImage($order_product->product_id, 'small')) }}" alt="">
                    </div>
                    <h4>Product Name: {{$order_product->products->name}}</h4>
                    <h5>Price: {{number_format($order_product->price, 2)}}</h5>
                    <h5>Qty: {{$order_product->qty}}</h5>
                    <h5>Total: {{number_format($order_product->price * $order_product->qty, 2)}}</h5><br><br>
                    <h5>Order Id: {{$order_product->order_id}}</h5>
                    <h5>Order No: </h5>

                    <br><br><br>
                    @if(!empty($dispute->disputeResult->result))
                        <h4>Owner Decision</h4>
                    <div class="content__box content__box--shadow alert-danger">
                        {{$dispute->disputeResult->result}}
                    </div>
                    @endif
                </div>
                <div class="col-xs-8">
                    <h4>Messages</h4><hr>
                    <div class="content__box content__box--shadow" id="data" style="max-height:500px;overflow: auto;">
                    @if(!empty($dispute))
                        @foreach($dispute->disputeMessages as $message)
                        @if($message->user_id == auth()->id())
                            @php $user = \App\User::where('id', auth()->id())->first(); @endphp
                            <div style="height:40px;width:40px;float:right;border: 1px solid darkgray;
                        border-radius: 50%;
                        overflow: hidden;
                        margin-left: 10px;
                        margin-bottom: 5px;">
                                <img src="{{$user->getImage()?$user->getImage()->smallUrl:asset('img/avatar.jpg')}}" alt="" >
                            </div>
                            <div style="background-color: #00aced;padding: 5px 10px; float: right; border-radius:20px;width: inherit;
max-width: 300px;

word-wrap: break-word;">
                                <span style="font-size:12px; color: #FFFFFF;">{{$message->message}}</span>
                            </div>
                            <div class="clearfix"></div>
                            <span style="display:block;line-height:10px;float: right;    font-size: 12px;
color: darkgrey;text-transform: capitalize">{{$user->user_name}}</span>
                            <div class="clearfix"></div>
                            <span class="pull-right" style="font-size:10px;color:lightgrey">{{humanizeDate($message->created_at)}}</span>
                            <div class="clearfix"></div>
                        @else
                            @php $user = \App\User::where('id', $message->user_id)->first(); @endphp
                            <div style="height:40px;width:40px;float:left;    border: 1px solid darkgray;
border-radius: 50%;
overflow: hidden;
margin-right: 10px;
margin-bottom: 5px;">
                                <img src="{{$user->getImage()?$user->getImage()->smallUrl:asset('img/avatar.jpg')}}" alt="" >

                            </div>
                            <div style="background-color: #3b5998;padding: 5px 10px;float:left; border-radius:20px;width: inherit;
max-width: 300px;
word-wrap: break-word;">
                                <span style="font-size:12px; color: #FFFFFF">{{$message->message}}</span>
                            </div>
                            <div class="clearfix"></div>
                            <span style="display:block;line-height:10px;    font-size: 12px;
color: darkgrey;text-transform: capitalize">{{$user->user_name}}</span>
                            <span style="font-size:10px;color:lightgrey">{{humanizeDate($message->created_at)}}</span>
                            <div class="clearfix"></div>
                        @endif
                        <br>
                        @endforeach
                        <div id="reload-vendor">

                        </div>
                    @else
                        <h5>No Discussion Available</h5>
                    @endif
                    </div>
                    <form action="{{route('vendor.disputes.store', $dispute->id)}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="reply">Reply</label>
                            <textarea name="message" id="" rows="5" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-xs" {{isset($dispute->disputeResult->result) ? 'disabled' : ''}}>Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <h6 class="text-center text-danger">Note: Decision is made by the owner on basis of your valid reasons.</h6>
@endsection

@push('scripts')
<script>
    $( document ).ready(function() {
        var elem = document.getElementById('data');
        elem.scrollTop = elem.scrollHeight// For Chrome, Firefox, IE and Opera
    });

    var id="<?php echo $dispute->id; ?>";

    setInterval(function(){
        reload();
    }, 1000);

    function reload() {
        $.ajax({
            type: "GET",
            data: {
                id: id
            },
            url: "{{ route('admin.message.reload')  }}",
            beforeSend: function (data) {
            },
            success: function (data) {
                $('#reload-vendor').html(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //
            },
            complete: function () {
                //
            }
        });
    }
</script>

@endpush