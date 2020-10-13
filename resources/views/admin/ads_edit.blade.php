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
	        		<td>{{ $details->user_id }}</td>
	        	</tr>
	        
	        
	        	<tr>
	        		<th>Date</th>
	        		<td>{{ $details->created_at }}</td>
	        	</tr>
	        	<tr>
	        		@php
	        			$status = \App\Model\WithdrawStatus::where('id',$details->status)->first()->status;
	        		@endphp
	        		<th> Status</th>
	        		<td><span class="label label-{{ $status }}">{{ $status }}</span></td>
	        	</tr>
	       
	        </table>

			<form action="{{ route('admin.ads.update',$details->id) }}" class="form-group" method="post">
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