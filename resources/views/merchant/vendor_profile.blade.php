@extends('merchant.layouts.app')
@section('title', 'Profile')

@section('content')

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <h3>User Profile</h3>
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="content__box content__box--shadow">
                    @if(isset(Auth::user()->vendorDetails->vendor_image))
                        <img class="img-responsive img-circle"
                             src="{{ url('/').'/'.Auth::user()->vendorDetails->vendor_image }}"
                             alt="User profile picture">
                    @endif
                        <h3 class="profile-username text-center">{{ $user->user_name }}</h3>

                        <p class="text-muted text-center">
                            {{ optional($user->roles->first())->display_name }}
                        </p>
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="content__box content__box--shadow">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">Info</a></li>
                        
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>User Name: </strong>{{ $user->user_name }}</li>
                                <li class="list-group-item"><strong>Email: </strong>{{ $user->email }}</li>
                                <li class="list-group-item"><strong>Phone: </strong>{{ $user->phone }}</li>
                                <li class="list-group-item"><strong>Address: </strong>@if(isset(Auth::user()->vendorDetails)) {{ Auth::user()->vendorDetails->address }} @endif</li>
                            </ul>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vendorModalCenter">Edit Info</button>
                            <!--update profile vendor-->
                            <div class="modal fade" id="vendorModalCenter" tabindex="-1" role="dialog" aria-labelledby="vendorModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="vendorModalLongTitle">Update your Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
            <form action="{{ route('vendor.vendors_details.profile.update') }}" id="myform" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="vendor_id" value=">@if(isset(Auth::user()->vendorDetails)) {{ Auth::user()->vendorDetails->id }} @endif ">
      <div class="modal-body">
              <div class="form-group">
    <label for="vendorusername">Username</label>
    <input type="name" class="form-control" id="vendorusername" aria-describedby="username" value="testvendor" readonly>
   
  </div>
  <div class="form-group">
    <label for="VenodrEmail">Email address</label>
    <input type="email" class="form-control" id="VenodrEmail" aria-describedby="emailHelp" value="testemail@gmail.com" readonly>
   
  </div>
  
  <div class="form-group">
    <label for="vendorpassword" id="passwordLabel">Password</label>
    <input type="password" name="password" class="form-control" id="vendorpassword" placeholder="Password" minlength=1 >
  </div>
  <div class="form-group">
    <label for="vendorcpassword" id="passwordLabelConfirm">Confirm Password</label>
    <input type="password" name="cpassword" class="form-control" id="vendorcpassword" placeholder="confirmPassword" minlength=1 >
        <span id="vmessage"></span>
  </div>
     <span id="vmessage"></span>
    <div class="row">
        <div class="col-sm-9">
               <div class="form-group">
    <label for="vpicture">Upload your Profile Image</label>
    <input type="file" class="form-control-file"  name="vpicture" id="vpicture" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
  </div>
        </div>
          <div class="col-sm-3">
               <div class="form-group">
   <img id="blah" src="@isset(Auth::user()->vendorDetails->vendor_image) {{ url('/').'/'.Auth::user()->vendorDetails->vendor_image }} @endisset" alt="your image" width="200" height="200">
  </div>
  
    <p id="error1" style="display:none; color:#FF0000;">
        Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
    </p>
    <p id="error2" style="display:none; color:#FF0000;">
        Maximum File Size Limit is 2MB.
    </p>
        </div>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <!--<input id="submit" type="submit" name="submit" value="Submit" />-->
        <button type="submit" id="vsubmit" name="submit" class="btn btn-primary">Update Profile</button>
      </div>
</form>
    </div>
  </div>
</div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
    
  
    
    
<script>
    $('input[type="submit"]').prop("disabled", true);
    var a=0;
    //binds to onchange event of your input field
    $('#vpicture').bind('change', function() {
        if ($('input:submit').attr('disabled',false)){
            $('input:submit').attr('disabled',true);
        }
        var ext = $('#picture').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            $('#error1').slideDown("slow");
            $('#error2').slideUp("slow");
            a=0;
        }else{
            var picsize = (this.files[0].size);
            if (picsize > 2048000){
                $('#error2').slideDown("slow");
                a=0;
            }else{
                a=1;
                $('#error2').slideUp("slow");
            }
            $('#error1').slideUp("slow");
            if (a==1){
                $('input:submit').attr('disabled',false);
            }
        }
    });
</script>

    <script type="text/javascript">
$('form').validate();

$('#vendorpassword, #vendorcpassword').on('keyup', function() {
  if ($('#vendorpassword').val() == $('#vendorcpassword').val()) {
    $('#vmessage').html('Matched').css('color', 'green');
    $('#vsubmit').prop('disabled', false);
  } else {
    $('#vmessage').html('Not Matching').css('color', 'red');
    $('#vsubmit').prop('disabled', true);
  }
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js'></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
@endsection