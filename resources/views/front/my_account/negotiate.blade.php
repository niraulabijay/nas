@extends('layouts.app')
@section('title', 'Order Details')

@section('content')


    <div class="col-md-8 col-md-offset-2">
        <div class="container wishlist__container tabcontent " id="negotiable">
            <div class="table-responsive hidden-xs">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Name</th>
                        <th>Sales Price</th>
                        <th>Negotiable Price</th>
                        <th>Checkout</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:100px;">
                                <div class="wishlist-product-img">
                                    <a href="">
                                        <img src="{{$negotiable->product->getImageAttribute()->mediumUrl}}"
                                             alt="">
                                    </a>
                                </div>
                            </td>
                            <td>
                                <span class="price">{{$negotiable->product->name}}</span>
                            </td>
                            <td>
                                <span class="price">{{$negotiable->product->sale_price}}</span>
                            </td>
                            <td>
                                @if($negotiable->fixed_price == null)
                                    <span class="price" style="color: #ccc">
												yet not fixed
											</span>
                                @else
                                    <span>
                                                  {{ $negotiable->fixed_price }}
                                                </span>
                                @endif
                            </td>

                            <td>

                                <a class="btn btn-default request"
                                   @if($negotiable->fixed_price ==null) disabled @endif>Checkout</a>


                            </td>

                        </tr>
                    <div id="negotiable_chat" class="modal fade in" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel" style="display: none; padding-left: 0px;">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="display: block;">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Sassung Mobile</h4>

                                    <div class="row col-xs-12>
														<div class=" content__box content__box--shadow
                                    " id="chatBox" style="height:350px;overflow: auto;">
                                    <div id="reload-admin">

                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>
            </div>
            </tbody>
            </table>

        </div>
        <h4>Messages</h4>
        <hr>
        <div class="content__box content__box--shadow" id="data" style="max-height:500px;overflow: auto;">
            @if(!empty($negotiable))
                @foreach($negotiable->negotiableMessages as $message)
                    @if($message->user_id == auth()->id())
                        @php $user = \App\User::where('id', auth()->id())->first(); @endphp
                        <div style="height:40px;width:40px;float:right;border: 1px solid darkgray;
                        border-radius: 50%;
                        overflow: hidden;
                        margin-left: 10px;
                        margin-bottom: 5px;">
                            <img src="{{$user->getImage()?$user->getImage()->smallUrl:asset('img/avatar.jpg')}}" alt="">
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
                        <span class="pull-right"
                              style="font-size:10px;color:lightgrey">{{humanizeDate($message->created_at)}}</span>
                        <div class="clearfix"></div>
                    @else
                        @php $user = \App\User::where('id', $message->user_id)->first(); @endphp
                        <div style="height:40px;width:40px;float:left;    border: 1px solid darkgray;
border-radius: 50%;
overflow: hidden;
margin-right: 10px;
margin-bottom: 5px;">
                            <img src="{{$user->getImage()?$user->getImage()->smallUrl:asset('img/avatar.jpg')}}" alt="">

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

        <div>
            <ul class="liststyle--none">
                <li><span class="mr-10 bold">Negotiate Fixed Price:</span>
                    @if($negotiable->fixed_price == null)
                        <span class="price" style="color: #ccc">
												yet not fixed
											</span>
                    @else
                        <span>
                                                  {{ $negotiable->fixed_price }}
                                                </span>
                    @endif

                </li>
            </ul>
        </div>
        <form action="{{ route('negotiable.store',$negotiable->id) }}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="reply">Reply</label>
                <textarea name="message" id="" rows="5" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-xs" @if(!empty($result) && $result == 7) disabled @endif>Reply</button>
        </form>
    </div>
</div>




@endsection


@push('scripts')
<script>
    $(document).ready(function () {
        var elem = document.getElementById('data');
        elem.scrollTop = elem.scrollHeight// For Chrome, Firefox, IE and Opera
    });

    var id = "<?php echo $negotiable->id; ?>";

    setInterval(function () {
        reload();
    }, 1000);

    function reload() {
        $.ajax({
            type: "get",
            data: {
                id: id
            },
            url: "{{ route('negotiable.reload') }}",
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