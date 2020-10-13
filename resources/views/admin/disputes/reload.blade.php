@foreach($dispute as $message)
    @if($message->user_id != auth()->id())
        @php $user = \App\User::where('id', $message->user_id)->first(); @endphp
        {{--@if($user->hasRole('admin'))--}}

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
        {{--@endif--}}
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