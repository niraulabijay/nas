<!-- Modal -->
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">All Details</h4>
	      </div>
	      <div class="modal-body">
	        <table class="table table-striped">
	        	<tr>
	        		<th>Vendors ID#</th>
	        		<td>{{ $details->id }}</td>
	        	</tr>
	        	<tr>
	        		<th>Vendor Company</th>
	        		<td></td>
	        	</tr>
	        	<tr>
	        		<th>Withdraw Amount</th>
					<td>{{ $details->amount }}</td>
	        	</tr>
	        	<tr>
	        		<th>Withdraw Process Date</th>
	        		<td>{{ $details->created_at }}</td>
	        	</tr>
	        	<tr>
	        		@php
	        			$status = \App\Model\WithdrawStatus::where('id',$details->status)->first()->status;
	        		@endphp
	        		<th>Withdraw Status</th>
	        		<td><span style="color:#000;" class="label label-{{ $status }}">{{ $status }}</span></td>
	        	</tr>
	        	<tr>
	        		<th>Account Name</th>
	        		<td>{{ $details->account_name }}</td>
	        	</tr>
				<tr>
					<th>Account Number</th>
					<td>{{ $details->account_no }}</td>
				</tr>

				<tr>
					<th>Account Status</th>
					<td>
						@if( $details->approve == 1 )
							<button class="btn btn-primary btn-xs withdraw-verify" data-id="{{$details->id}}">Verify</button>
						@else
							<button class="btn btn-danger btn-xs withdraw-verify" data-id="{{$details->id}}">Non-Verify</button>
						@endif
					</td>
				</tr>
	        
	        	<tr>
	        		<th>Withdraw Method</th>
	        		<td>Bank Transfer</td>
	        	</tr>
	        </table>



			<form action="{{ route('admin.withdraw.status',$details->id) }}" class="form-group" method="post">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="">Change status</label>
					<select name="status" class="form-control">
						@foreach($withDrawStatus as $s)
							<option value="{{ $s->id }}">{{ $s->status }}</option>
						@endforeach
					</select>
				</div>
				<input type="submit" name="submit" class="btn btn-primary" value="Change Status">
		  	</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>