<!-- Modal -->
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Message Details</h4>
	      </div>
	      <div class="modal-body">
	        <table class="table table-striped">
	        	<tr>
	        		<th>Name</th>
	        		<td>{{ $detail->name }}</td>
	        	</tr>
	        	<tr>
	        		<th>Email</th>
	        		<td>{{ $detail->email }}</td>
	        	</tr>
	        	<tr>
	        		<th>Phone</th>
					<td>{{ $detail->phone }}</td>
	        	</tr>
	        	<tr>
	        		<th>Subject</th>
	        		<td>{{ $detail->subject }}</td>
	        	</tr>
	        	<tr>
	        		<th>Message</th>
	        		<td>{{ $detail->message }}</td>
	        	</tr>
	        </table>
	      </div>
	      <div class="modal-footer">
	      	<form action="{{ route('delete.contact.message',$detail->id) }}" method="post" id="remove-message-{{ $detail->id }}" style="display: none;">
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
	      	<a href="" onclick="
	      		if(confirm('Are you sure you want to remove this message.'))
	      		{
	      			event.preventDefault();document.getElementById('remove-message-{{ $detail->id }}').submit();
	      		}
	      		else
	      		{
	      			event.preventDefault();
	      		}
	      	" class="btn btn-danger">Remove</a>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>