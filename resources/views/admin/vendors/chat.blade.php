
    <!-- Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">Talk with {{$vendor->name}}</h4>
                </div>

                <div class="modal-body">
                    <div class="content__box content__box--shadow" id="chatBox" style="height:350px;overflow: auto;">
                        @if(!empty($messages))
                            @foreach($messages as $message)
                                @if($message->admin_id == auth()->id() && $message->active == 0)
                                    @php $user = \App\User::where('id', auth()->id())->first(); @endphp
                                    <div style="height:40px;width:40px;float:left;border: 1px solid darkgray;
                        border-radius: 50%;
                        overflow: hidden;
                        margin-right: 10px;
                        margin-bottom: 5px;">
                                        <img src="{{$user->getImage()? $user->getImage()->smallUrl : asset('img/avatar.jpg')}}" alt="" >
                                    </div>

                                    @if($message->message)
                                        <div style="background-color: #00aced;padding: 5px 10px; float: left; border-radius:20px;width: initial;max-width: 300px;word-wrap: break-word;" class="chat-conversation-body">
                                            <span style="font-size:12px; color: #FFFFFF;" class="chat-item-last-message">{{$message->message}}</span>
                                        </div>
                                        <div class="clearfix"></div>
                                    @endif
                                    @if($message->image)
                                        <div style="width: 50%; height: auto; margin-left: 50px;display: block;border: 1px solid #ccc;">
                                            <a href="{{ $message->image }}" class="product-img-zoom" title="Zoom">
                                                <img src="{{ $message->image}}" alt="">
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                    @endif
                                    <span style="display:block;line-height:10px;float: left;font-size: 12px;color: darkgrey;text-transform: capitalize">{{$user->name}}</span>
                                    <div class="clearfix"></div>
                                    <span style="font-size:10px;color:lightgrey;float: left">{{humanizeDate($message->created_at)}}</span>
                                    <div class="clearfix"></div>
                                @else
                                    @php $user = \App\User::where('id', $message->vendor_id)->first(); @endphp
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
    word-wrap: break-word;" class="chat-conversation-body" >
                                            <span style="font-size:12px; color: #FFFFFF" class="chat-item-last-message">{{$message->message}}</span>
                                        </div>
                                        <div class="clearfix"></div>
                                    @endif
                                    @if($message->image)
                                        <div style="width: 50%; height: auto; margin-right: 50px;display: block;float: right;border: 1px solid #ccc;">
                                            <a href="{{ $message->image }}" class="product-img-zoom" title="Zoom">
                                                <img src="{{ $message->image }}" alt="">
                                            </a>
                                        </div>
                                    @endif
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
                    <div>
                        <form action="" method="post" enctype="multipart/form-data" id="chat">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{ $vendor->id }}">
                            <div class="form-group">
                                <textarea type="text" id="chat-input" name="chat" rows="5" class="form-control"></textarea>
                                <br>
                            </div>
                            <input type="file" name="image" id="image">
                            <input type="submit" value="Send" class=" btn btn-primary btn-xs pull-right btn-send">
                        </form>
                    </div>
                </div>

            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    <!-- modal -->

    <script>
        $('.product-img-zoom').magnificPopup({
            type: 'image'
            // other options
        });
    </script>

