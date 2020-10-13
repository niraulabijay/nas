<!-- Modal -->

  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Vendor Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" id="updateVendorDetails">
          <input type="hidden" name="id" value="{{ $vendor_details->id }}">
      {{csrf_field()}}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $vendor_details->name }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $vendor_details->email }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $vendor_details->phone }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $vendor_details->address }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="type">Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ $vendor_details->type }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="pan_number">Pan No</label>
            <input type="text" name="pan_number" id="pan_number" class="form-control" value="{{ $vendor_details->pan_number }}">
          </div>
        </div>
        {{-- <div class="col-md-6">
          <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control">
          </div>
        </div> --}}
        <div class="col-md-6">
          <div class="form-group">
            <label for="seo_keywords">Seo Keywords</label>
            <input type="text" name="seo_keywords" id="seo_keywords" class="form-control" value="{{ $vendor_details->seo_keywords }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="seo_description">Seo Description</label>
            <input type="text" name="seo_description" id="seo_description" class="form-control" value="{{ $vendor_details->seo_description }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5">{{ $vendor_details->description }}</textarea>
          </div>
        </div>
      </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-vendor-details-update">Save changes</button>
      </div>
    </div>
  </div>
