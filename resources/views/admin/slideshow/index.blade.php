@extends('admin.layouts.app')
@section('title', 'Slideshow')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <div class="modal right fade " id="quickViewModal" tabindex="-1"></div>

    <section>
    <div class="row">
        <h3>All Slideshows</h3>
        <div class="col-md-12 content__box content__box--shadow">
            <table id="slideshowTable" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Link</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th class="sorting-false">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                    <th>SN</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Link</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th class="sorting-false">Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
    $(document).on("click", ".btn-slideshow-add", function (e) {
        e.preventDefault();
        var $this = $(this);

        var params=$('#slideshowForm').serializeArray();
        var image = new FormData();

        image.append('image', $('input[type=file]')[0].files[0]);
        $.each(params,function(i,val){
            image.append(val.name,val.value)

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('admin.slideshow.store') }}",
            contentType: false,
            processData: false,
            data: image,
            beforeSend: function (data) {
            },
            success: function (data) {
//                sweetAlert('success', 'Success');

                $this.button('loading');
                $(".alert-success").fadeTo(5000, 5000).html(data).slideUp(500, function() {
                    $("#alert").slideUp(5000);
                });

            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorsHolder = '';
                errorsHolder += '<ul>';

                var err = eval("(" + xhr.responseText + ")");
                $.each(err.errors, function (key, value) {
                    errorsHolder += '<li>' + value + '</li>';
                });


                errorsHolder += '</ul>';

                $(".alert-danger").fadeTo(5000, 5000).html(errorsHolder).slideUp(500, function() {
                    $("#alert").slideUp(5000);
                });

            },
            complete: function () {
                $this.button('reset');

                $("#slideshowForm")[0].reset();
                $('#slideshowTable').DataTable().ajax.reload();


            }
        });


    });
    $(document).ready(function(){
        $('#slideshowTable').DataTable({
            aaSorting: [3,'desc'],
            processing: true,
            serverSide: true,
            columns: [
                {"data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'image', 
                    orderable: false, 
                    render: function (data, type, row) {
                        return '<img src="{{ url('/') }}' + data + '" style="width:30%;height:auto;">';
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'link', name: 'link'},
                {data: 'priority', name: 'priority'},
                {
                    data: 'status',
                    render: function (data, type, row) {
                        var intData = parseInt(data);
                        return intData !== 1 ? '<span class="label label-danger">Disabled</span>' : '<span class="label label-success">Enabled</span>';
                    }
                },

                {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                        var tempEditUrl = "{{ route('admin.slideshow.edit', ':id') }}";
                        tempEditUrl = tempEditUrl.replace(':id', data);

                        var actions = '';
                        actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-default' style='margin-right: 5px;'><span class='lnr lnr-pencil'></span></a>";
                        actions += "<button type='submit' class='btn btn-xs btn-default btn-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>";

                        return actions;
                    }
                }

            ],
            ajax: '{{route('admin.slideshow.json')}}'

        });
    });
    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete?')) {
                return false;
            }

        var $this = $(this);

        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.slideshow.delete', ':id') }}";
        tempDeleteUrl = tempDeleteUrl.replace(':id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: tempDeleteUrl,
            data: id,
            beforeSend: function (data) {

            },
            success: function (data) {
                $(".alert-success").fadeTo(5000, 5000).html(data).slideUp(500, function() {
                    $("#alert").slideUp(5000);
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorsHolder = '';
                errorsHolder += '<ul>';

                var err = eval("(" + xhr.responseText + ")");
                $.each(err.errors, function (key, value) {
                    errorsHolder += '<li>' + value + '</li>';
                });


                errorsHolder += '</ul>';

                $(".alert-danger").fadeTo(5000, 5000).html(errorsHolder).slideUp(500, function() {
                    $("#alert").slideUp(5000);
                });
            },
            complete: function () {
                $('#slideshowTable').DataTable().ajax.reload();
            }
        });
    });
</script>

@endpush