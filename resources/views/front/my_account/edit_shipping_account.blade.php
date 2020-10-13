    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel">Edit Shipping Address</h4>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
           <form action="{{ route('my-account.shipping.update', $shipping->id) }}" method="post">
	            {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                        		<label for="acc_firstName">First Name *</label>
                        		<input type="text" class="form-control" id="acc_firstName" name="first_name" value="{{ $shipping->first_name }}" required>
                        	</div>
            	        </div>
                    	<div class="col-md-6">
                        	<div class="form-group">
                        		<label for="acc_lastName">Last Name *</label>
                        		<input type="text" class="form-control" id="acc_lastName" name="last_name" value="{{ $shipping->last_name }}" required>
                        	</div>
                    	</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ $shipping->email }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                        	<div class="form-group">
                        		<label for="country">Country *</label>
                        		<select class="form-control" id="country" name="country" required>
                        			<option value="Nepal" selected>Nepal</option>
                        		</select>
                        	</div>
                    	</div>
                    
                         <div class="col-md-6">
                            <label for="inputAddress">Zone</label>
                            <select class="uk-select" id="zone2" name="zone">
                                <option value="0" disabled="" selected>Select Zone</option>
                                @foreach(\App\DeliveryCharge::where('parent_id',0)->get() as $zones)
                                    <option value="{{$zones->id}}">{{$zones->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('zone'))
                                <span class="help-block">
                        {{ $errors->first('zone') }}
                    </span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="inputdistrict">District</label>
                            <select class="uk-select" id="district2" name="district">
                                <option value="0" disabled="" selected>Select Option</option>

                            </select>
                            @if ($errors->has('district'))
                                <span class="help-block">
                        {{ $errors->first('district') }}
                    </span>

                            @endif
                        </div>
                        </div>
                        <div class="col-md-6">
                            <label for="area">Area</label>
                            <select class="uk-select" id="area2" name="area">
                                <option value="0">Select Option</option>

                            </select>
                            @if ($errors->has('area'))
                                <span class="help-block">
                        {{ $errors->first('area') }}
                    </span>

                            @endif
                        </div>
                        </div>
                	    
                        <div class="row">
                            
                        </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
     <script>
        document.getElementById("zone2").onchange = function() {

            var e = document.getElementById("zone2");
            var zone = e.options[e.selectedIndex].value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                url: "{{ route('checkout.zone') }}",
                data:{
                    zone:zone
                },
                success: function(data) {
//                console.log(data);

                    $('#district2').html(data);
                }

            });
        };

        document.getElementById("district2").onchange = function() {

            var e = document.getElementById("district2");
            var zone = e.options[e.selectedIndex].value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                url: "{{ route('checkout.zone') }}",
                data:{
                    zone:zone
                },
                success: function(data) {
                    $('#area2').html(data);

                }

            });
        };


    </script>