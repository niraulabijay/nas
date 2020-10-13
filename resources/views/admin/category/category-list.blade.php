@extends('admin.layouts.app')
@section('title', 'Category')

@section('content')
    <div class="modal right fade" id="quickViewModal" tabindex="-1"></div>
    <section>
        <div class="row">
            <div class="col-xs-3">
                <h3>Add Category</h3>
                <div class="content__box content__box--shadow">
                    @include('admin.category.category-add')    
                </div>
            </div>

            <div class="col-xs-9">
                <h3 class="text-center">All Categories</h3>
                <div class="content__box content__box--shadow">
                    <table id="categoryTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Category Name</th>
                                <th>Category Slug</th>
                                <th>Image</th>
                                <th>Parent Name</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S.N</th>
                                <th>Category Name</th>
                                <th>Category Slug</th>
                                <th>Image</th>
                                <th>Parent Name</th>
                                <th>Modify</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#categoryTable').DataTable({
            aaSorting: [0, 'desc'],
            processing: true,
            serverSide: true,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', 
                    render: function (data, type, row) {
                        return '<a href="#" class="btn-edit" data-id="' + row.id + '">' + data + '</a>';
                    }
                },
                {data: 'slug', name: 'slug'},
                {data: 'category_image', 
                    render: function (data, type, row) {
                        return '<img src="'+ data +'" style="width: 100px;height: auto; }" >';
                    }
                },
                {data: 'parent_name', name: 'parent_name'},

                {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {

                        var actions = '';
                        actions += "<button type='submit' class='btn btn-xs btn-default btn-edit' data-id=" + row.id + " style='margin-right: 5px;'><span class='lnr lnr-pencil'></span></button>";
                        actions += "<button type='submit' class='btn btn-xs btn-default btn-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>";

                        return actions;
                    }
                }
            ],
            ajax: '{{route('admin.category.json')}}'
        });
    });
</script>
<script>
    $(document).on("click", ".category-add", function (e) {
        e.preventDefault();
        var form = new FormData($('#categoryForm')[0]);
        var params = $('#categoryForm').serializeArray();
        select = document.getElementById('theSelect');

        $.each(params, function (i, val) {
            form.append(val.name, val.value)

        });
//        for (var pair of image.entries()) {
//            console.log(pair[0]+ ', ' + pair[1]);
//        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('admin.category.store') }}",
            contentType: false,
            processData: false,
            data: form,
            beforeSend: function (data) {
            },
            success: function (data) {
                window.location.reload();
                // sweetAlert('success', 'Success');
                $(".alert-success").fadeTo(5000, 5000).html(data).slideUp(500, function() {
                    $("#alert").slideUp(5000);
                });

                var select = $("#theSelect"), options = '';
                select.empty();

                for (var i = 0; i < data.length; i++) {

                    options += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                    if (data[i].subCategory) {

                        $.each(data[i].subCategory, function () {
//                            $.each(this, function(k, v) {
                            options += "<option value='" + data[i].subCategory[i].id + "'>" + data[i].subCategory[i].name + "</option>";
//                     });
                        });
                    }
                }
                select.append(options);
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
//                window.location.reload();
                $("#categoryForm")[0].reset(),
                $('#categoryTable').DataTable().ajax.reload();
            }
        });
    });
</script>
<script>
    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();

        if (!confirm('Are you sure you want to delete?')) {
            return false;
        }

        var $this = $(this);

        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.category.delete', ':id') }}";
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
                window.location.reload();
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
                $('#categoryTable').DataTable().ajax.reload();
            }
        });
    });
</script>
<script>
    var $modal = $('#quickViewModal');
    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();
        var $this = $(this);
        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.category.edit', ':id') }}";
        tempDeleteUrl = tempDeleteUrl.replace(':id', id);

        $modal.load(tempDeleteUrl, function (response) {
            $modal.modal({show: true});

        });


    });
</script>
<script>
    $(document).on("click", ".category-update", function (e) {
        e.preventDefault();
        var form = new FormData($('#catgoryUpdate')[0]);
        var params = $('#catgoryUpdate').serializeArray();

        $.each(params, function (i, val) {
            form.append(val.name, val.value)

        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('admin.category.update') }}",
            contentType: false,
            processData: false,
            data: form,

            beforeSend: function (data) {
            },
            success: function (data) {
                $(".alert-success").fadeTo(5000, 5000).html(data).slideUp(500, function() {
                    $("#alert").slideUp(5000);
                });
                $('#quickViewModal').modal('hide');
                window.location.reload();
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
//                window.location.reload();
                $('#categoryTable').DataTable().ajax.reload();
            }
        });
    });
</script>


@endpush