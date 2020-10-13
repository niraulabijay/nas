@extends('merchant.layouts.app')
@section('title', 'Chat')

@section('content')
    <section>
        <div class="row">
            <h4 class="text-center">Talk with Owner</h4>
            <div class="col-xs-8 col-xs-offset-2">
                <div class="content__box content__box--shadow" id="chatBox" style="height:350px;overflow: auto;">
                    @if(!empty($messages))
                        @foreach($messages as $message)
                            @if($message->vendor_id == auth()->id() && $message->active == 1)
                                @php $user = \App\User::where('id', auth()->id())->first(); @endphp
                                <div style="height:40px;width:40px;float:left;border: 1px solid darkgray;
                        border-radius: 50%;
                        overflow: hidden;
                        margin-right: 10px;
                        margin-bottom: 5px;">
                                    <img src="{{$user->getImage()? $user->getImage()->smallUrl : asset('img/avatar.jpg')}}" alt="" >
                                </div>
                                @if($message->message)
                                <div style="background-color: #00aced;padding: 5px 10px; float: left; border-radius:20px;width: initial;
max-width: 300px;

word-wrap: break-word;">
                                    <span style="font-size:12px; color: #FFFFFF;">{{$message->message}}</span>
                                </div>
                                <div class="clearfix"></div>
                                @endif
                                @if($message->image)
                                    <div style="width: 30%; height: auto; margin-left: 50px;display: block;border: 1px solid #ccc;">
                                        <a href="{{ $message->image }}" class="product-img-zoom" title="Zoom">
                                            <img src="{{ $message->image }}" alt="">
                                        </a>
                                    </div>
                                @endif
                                <div class="clearfix"></div>
                                <span style="display:block;line-height:10px;float: left;font-size: 12px;color: darkgrey;text-transform: capitalize">{{$user->user_name}}</span>
                                <div class="clearfix"></div>
                                <span style="font-size:10px;color:lightgrey;float: left">{{humanizeDate($message->created_at)}}</span>
                                <div class="clearfix"></div>
                            @else
                                @php $user = \App\User::where('id', $message->admin_id)->first(); @endphp
                                <div style="height:40px;width:40px;float:right;    border: 1px solid darkgray;
border-radius: 50%;
overflow: hidden;
margin-left: 10px;
margin-bottom: 5px;">
                                    <img src="{{$user->getImage()?$user->getImage()->smallUrl:asset('img/avatar.jpg')}}" alt="" >
                                </div>
                                @if($message->message)
                                <div style="background-color: #3b5998;padding: 5px 10px;float:right; border-radius:20px;width: initial;
max-width: 300px;
word-wrap: break-word;">
                                    <span style="font-size:12px; color: #FFFFFF">{{$message->message}}</span>
                                </div>
                                <div class="clearfix"></div>
                                @endif
                                @if($message->image)
                                    <div style="width: 30%; height: auto; margin-right: 50px;display: block;float: right;border: 1px solid #ccc;">
                                        <a href="{{ $message->image }}" class="product-img-zoom" title="Zoom">
                                            <img src="{{ $message->image }}" alt="" }}">
                                        </a>
                                    </div>
                                @endif
                                <div class="clearfix"></div>
                                <span style="display:block; line-height:10px; font-size: 12px; color: darkgrey; text-transform: capitalize;float: right;">{{$user->user_name}}</span>
                                <div class="clearfix"></div>
                                <span style="font-size:10px;color:lightgrey;float: right">{{humanizeDate($message->created_at)}}</span>
                                <div class="clearfix"></div>
                            @endif
                            <br>
                        @endforeach
                        <div id="reload-admin">

                        </div>
                    @else
                        <h5>No Message Yet</h5>
                    @endif
                </div>
                <form action="{{ route('vendor.chat.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $admin->id }}">
                    <div class="form-group">
                        <textarea name="chat" id="" rows="5" class="form-control"></textarea><br>
                        <input type="file" name="image"><br>
                        <input type="submit" class="btn btn-primary btn-xs" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $( document ).ready(function() {
        var elem = document.getElementById('chatBox');
        elem.scrollTop = elem.scrollHeight// For Chrome, Firefox, IE and Opera
    });

    $('.product-img-zoom').magnificPopup({
        type: 'image'
        // other options
    });

</script>
@endpush