<style>
	.modal-header .close{
	    margin-top: 5px;
	    margin-right: 5px;
	    opacity: 0.7;
	    color: #fff;
	}
</style>
<!-- Modal -->
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times-circle"></i></button>
	        <h4 class="modal-title sidebar-title">Reply Message</h4>
	      </div>
	      <div class="modal-body">
	        <form action="">
	        	{{ csrf_field() }}
	        	<div class="form-group">
	        		<label for="name">Name</label>
	        		<input type="text" class="form-control" name="name" id="name" value="{{ $detail->name }}" disabled="disabled" />
	        	</div>
	        	<div class="form-group">
	        		<label for="email">Email</label>
	        		<input type="email" class="form-control" name="email" id="email" value="{{ $detail->email }}" disabled="disabled" />
	        	</div>
	        	<div class="form-group">
	        		<label for="subject">Subject</label>
	        		<input type="text" class="form-control" name="subject" id="subject" value="{{ $detail->subject }}" disabled="disabled" />
	        	</div>
	        	<div class="form-group">
	        		<label for="msg">Message</label>
	        		<textarea name="msg" id="msg" class="form-control shortdescrip"></textarea>
	        	</div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>