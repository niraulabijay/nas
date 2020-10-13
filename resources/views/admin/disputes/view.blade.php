@extends('admin.layouts.app')
@section('title', 'Dispute Details')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <section>
        <div class="row">
            <h3>View Dispute Details</h3>
            <div class="col-xs-8 col-xs-offset-2">
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th class="text-center">Product Image</th>
                        <th class="text-center">Product Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <img src="{{ asset(getProductImage($order_product->product_id, 'small')) }}" alt="{{$order_product->products->product_name}}" style="width: 10%; height: auto">
                        </td>
                        <td><a href="#"> {{$order_product->products->product_name}}</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <h4 class="text-center">Disputes Details for this Product</h4>
            <div class="col-xs-8 col-xs-offset-2 content__box content__box--shadow" id="data" style="max-height:400px;overflow: auto;">
                @if(!empty($dispute))
                    @foreach($dispute->disputeMessages as $message)
                        @if($message->user_id == auth()->id())
                            @php $user = \App\User::where('id', auth()->id())->first(); @endphp
                            <div style="height:40px;width:40px;float:left;border: 1px solid darkgray;
                        border-radius: 50%;
                        overflow: hidden;
                        margin-right: 10px;
                        margin-bottom: 5px;">
                                <img src="{{$user->getImage()? $user->getImage()->smallUrl : asset('img/avatar.jpg')}}" alt="" >
                            </div>
                            <div style="background-color: #00aced;padding: 5px 10px; float: left; border-radius:20px;width: initial;
max-width: 300px;

word-wrap: break-word;">
                                <span style="font-size:12px; color: #FFFFFF;">{{$message->message}}</span>
                            </div>
                            <div class="clearfix"></div>
                            <span style="display:block;line-height:10px;float: left;font-size: 12px;color: darkgrey;text-transform: capitalize">{{$user->name}}</span>
                            <div class="clearfix"></div>
                            <span style="font-size:10px;color:lightgrey;float: left">{{humanizeDate($message->created_at)}}</span>
                            <div class="clearfix"></div>
                        @else
                            @php $user = \App\User::where('id', $message->user_id)->first(); @endphp
                            <div style="height:40px;width:40px;float:right;    border: 1px solid darkgray;
border-radius: 50%;
overflow: hidden;
margin-left: 10px;
margin-bottom: 5px;">
                                <img src="{{$user->getImage()?$user->getImage()->smallUrl:asset('img/avatar.jpg')}}" alt="" >

                            </div>
                            <div style="background-color: #3b5998;padding: 5px 10px;float:right; border-radius:20px;width: initial;
max-width: 300px;
word-wrap: break-word;">
                                <span style="font-size:12px; color: #FFFFFF">{{$message->message}}</span>
                            </div>
                            <div class="clearfix"></div>
                            <span style="display:block; line-height:10px; font-size: 12px; color: darkgrey; text-transform: capitalize;float: right;">{{$user->first_name}}</span>
                            <div class="clearfix"></div>
                            <span style="font-size:10px;color:lightgrey;float: right">{{humanizeDate($message->created_at)}}</span>
                            <div class="clearfix"></div>
                            @endif
                        <br>
                    @endforeach
                        <div id="reload-admin">

                        </div>
                @else
                    <h5>No Discussion Available</h5>
                @endif
            </div>
            <div class="col-xs-8 col-xs-offset-2">
            <form action="{{route('admin.disputes.store', $dispute->id)}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="message">Comment</label>
                    <textarea name="message" id="discussion" cols="30" rows="5" class="form-control" placeholder="Post Your Reply Here "></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-xs" {{isset($dispute->disputeResult->result) ? 'disabled' : ''}}>Comment</button>
            </form>
            </div>
        </div>
        <br>
        @if(!empty($dispute->disputeResult->result))
            <div class="row">
            <div class="col-xs-offset-2 col-xs-8">
            <h5 class="text-danger alert-danger">{{$dispute->disputeResult->result}}</h5>
            <h6>Decision is in favour of <span class="text-danger">{{\App\User::where('id',$dispute->disputeResult->user_id)->first()->name}}</span></h6>
            </div>
            </div>
        @endif
        <div class="row">
            <h4 class="text-center">Decision in favour of buyer or seller</h4>
            <div class="col-xs-8 col-xs-offset-2 content__box content__box--shadow">
                <form action="{{route('admin.dispute.result_store')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="dispute_id" value="{{$dispute->id}}">
                    <div class="form-group">
                        <textarea name="dispute_result" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <input type="radio" name="favour" value="{{$dispute->product->order->user_id}}"> Buyer
                        <input type="radio" name="favour" value="{{$dispute->product->owner_id}}"> Seller
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-xs text-center">Post Result</button>
                        <a href="{{route('admin.disputes')}}" class="btn btn-primary btn-xs text-center">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
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
                $('#reload-admin').html(data);
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