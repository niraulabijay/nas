<div id="edit_account_info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit your account info</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('my-account.info.store') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <!--<div class="col-md-6">-->
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="exampleInputFirstName">First Name</label>
                        <input type="text" class="form-control" id="exampleInputFirstName" placeholder="First Name"
                               name="first_name" value="{{ Auth::User()->first_name }}">
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                    {{ $errors->first('first_name') }}
                                </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="exampleInputLastName">Last Name</label>
                        <input type="text" class="form-control" id="exampleInputLastName" placeholder="Last Name"
                               name="last_name" value="{{ Auth::User()->last_name }}">
                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                    {{ $errors->first('last_name') }}
                                </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                        <label for="exampleInputUserName">User Name</label>
                        <input type="text" class="form-control" id="exampleInputUserName" placeholder="User Name"
                               name="user_name" value="{{ Auth::User()->user_name }}">
                        @if ($errors->has('user_name'))
                            <span class="help-block">
                                    {{ $errors->first('user_name') }}
                                </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email"
                               name="email" value="{{ Auth::User()->email }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="change_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Change your password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('my-account.user.create') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                        <label for="exampleInputPassword">Old-Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword" placeholder="Old Password"
                               name="current_password">
                        @if ($errors->has('current_password'))
                            <span class="help-block">
                                {{ $errors->first('current_password') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                               name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">Re-Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Re-Password"
                               name="password_confirmation">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="edit_personal_info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Your Personal Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('my-account.user-info.create') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }} text-center">
                        <label for="first_name">{{ Auth::User()->user_name }}</label>
                    </div>
                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                        <label for="gender">Gender</label>
                        <!-- Default unchecked -->
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="male" value="1" name="gender"  @isset($user_info) {{ $user_info->gender == 1 ? 'checked':'' }} @endisset>
                            <label class="custom-control-label" for="male">Male </label>
                        </div>

                        <!-- Default checked -->
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input"  id="female" value="0" name="gender" @isset($user_info) {{ $user_info->gender == 0 ? 'checked':'' }} @endisset >
                            <label class="custom-control-label" for="female">Female </label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('user_image') ? ' has-error' : '' }}">
                        <label>Profile Picture</label>
                        {{-- <label for="profileImage">
                            <i class="fa fa-upload"></i>
                        </label> --}}
                        <input type="file" class="form-control" name="user_image" id="profileImage">
                        @if ($errors->has('user_image'))
                            <span class="help-block">
                                {{ $errors->first('user_image') }}
                            </span>
                        @endif
                        @if(isset($user_info->image))
                            <img src="{{ url('').'/'.$user_info->image }}" style="width: 30%;">
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                        <label>Date Of Birth</label>
                        <input type="date" class="form-control" placeholder="Choose" name="dob"
                               value="{{ isset($user_info->dob)?$user_info->dob:'' }}">
                        @if ($errors->has('dob'))
                            <span class="help-block">
                                {{ $errors->first('dob') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>