@extends('layouts.app')
@section('title', 'Disputes')

@section('content')
    @include('partials.message-error')
    @include('partials.message-success')

    <div class="container">
        <div class="row">
            <div class="content-box content-box--shadow">
                <div class="panel panel-default no-border-shadow">
                    <div id="ar-right-1">
                        <div class="panel-body"><div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr class="warning">
                                        <td class="text-left">Image</td>
                                        <td class="text-left">Product Name</td>
                                        <td class="text-right">Quantity</td>
                                        <td class="text-right">Unit Price</td>
                                        <td class="text-right">Total</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left">
                                                <img src="{{ asset(getProductImage($order_product->product_id, 'small')) }}" alt="" style="width: 20%;">
                                            </td>
                                            <td class="text-left"><a href="">{{ \App\Model\Product::findorfail($order_product->product_id)->product_name }}</a>
                                            </td>
                                            <td class="text-right">{{ $order_product->qty }}</td>
                                            <td class="text-right">Rs.{{ $order_product->price }}</td>
                                            <td class="text-right">Rs.{{ number_format($order_product->qty * $order_product->price , 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-xs-8 col-xs-offset-2 user-disputes">
                @if(!empty($dispute->disputeResult->result))
                    <h4>Owner Decision</h4>
                    <div class="content-box content-box--shadow alert-danger">
                        {{$dispute->disputeResult->result}}
                    </div><br><br>
                @endif
                @if($dispute->status != '1' && $dispute->status != '0')
                    <div class="alert alert-danger">
                       <h4>Owner should approved your reason in order to discuss with seller.</h4>
                    </div>
                @else
                    <label for="discussion">Discussion Board</label>
                    <div class="content-box content-box--shadow" id="data" style="max-height:500px;overflow: auto;">
                    @if($dispute->disputeMessages->isNotEmpty())
                        @foreach($dispute->disputeMessages as $message)
                            @if($message->user_id != auth()->id())
                                @php $user = \App\User::where('id', $message->user_id)->first(); @endphp
                                @if($user->hasRole('admin'))

                                <div style="height:40px;width:40px;float:right;border: 1px solid darkgray;
                                    border-radius: 50%;
                                    overflow: hidden;
                                    margin-left: 10px;
                                    margin-bottom: 5px;">
                                    <img src="{{$user->getImage()?$user->getImage()->smallUrl:asset('img/avatar.jpg')}}" alt="" >
                                </div>
                                <div style="background-color: #00aced;padding: 5px 10px; float: right; border-radius:20px;width: inherit;
    max-width: 500px;

    word-wrap: break-word;">
                                    <span style="font-size:12px; color: #FFFFFF;">{{$message->message}}</span>
                                </div>
                                <div class="clearfix"></div>
                                        <span style="display:block;line-height:10px;float: right;    font-size: 12px;
    color: darkgrey">{{$user->first_name}}</span>
                                    <div class="clearfix"></div>
                                <span class="pull-right" style="font-size:10px;color:lightgrey">{{humanizeDate($message->created_at)}}</span>
                                <div class="clearfix"></div>
                                @endif
                            @else
                                @php $user = \App\User::where('id', auth()->id())->first(); @endphp
                                <div style="height:40px;width:40px;float:left;    border: 1px solid darkgray;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 10px;
    margin-bottom: 5px;">
                                    <img src="{{$user->getImage()?$user->getImage()->smallUrl:asset('img/avatar.jpg')}}" alt="" >
                                </div>
                                <div style="background-color: #3b5998;padding: 5px 10px;float:left; border-radius:20px;width: inherit;
    max-width: 500px;
    word-wrap: break-word;">
                                    <span style="font-size:12px; color: #FFFFFF">{{$message->message}}</span>
                                </div>
                                        <div class="clearfix"></div>
                                        <span style="display:block;line-height:10px;    font-size: 12px;
    color: darkgrey">{{$user->first_name}}</span>
                                        <span style="font-size:10px;color:lightgrey">{{humanizeDate($message->created_at)}}</span>
                                <div class="clearfix"></div>
                            @endif
                            <br>
                        @endforeach
                        <div id="reload">

                        </div>
                    @else
                        <h5>No Discussion Available</h5>
                    @endif

                    </div>
                    <br>
                    <form action="{{route('disputes.store', $dispute->id)}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="discussion" cols="30" rows="5" class="form-control" placeholder="Post Your Complain Here"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" {{isset($dispute->disputeResult->result) ? 'disabled' : ''}}>Post Dispute</button>
                    </form>
                @endif
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
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
                $('#reload').html(data);
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