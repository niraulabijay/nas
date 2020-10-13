@extends('admin.layouts.app')
@section('title', 'Users')

@section('content')
    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li> {{ $e }}</li>
                @endforeach
            </ul>

        </div>
    @endif
    @include('partials.message-success')
    @include('partials.message-error')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <h3 class="box-title">Users</h3>
            <div class="col-xs-12">
                <div class="content__box content__box--shadow">
                    <table id="example1" class="table table-bordered table-striped datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            @if(request('role') != 'client')
                            <th>Role</th>
                            @endif
                            <th>Date</th>
                            <th class="sorting-false">Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            @if(request('role') != 'client')
                            <th>Role</th>
                            @endif
                            <th>Date</th>
                            <th class="sorting-false">Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            var sortSelector = $('#sort-users');

            var Table = $('.datatable').DataTable({
                columnDefs: [
                    {"width": "2%", "targets": 0},
                    {"width": "5%", "targets": 1}
                ],
                processing: true,
                columns: [
                    {
                        "data": "id",
                       render: function (data, type, row, meta) {
                           return meta.row + meta.settings._iDisplayStart + 1;
                       }
                    },
                    {
                        data: 'avatar',
                        orderable: false,
                        render: function (data, type, row) {
                            return '<img src="' + data + '" style="width: 100%; height:auto;">';
                        }
                    },
                    {
                        data: 'name',
                        render: function (data, type, row) {
                            return '<a href="{{ url('/admin/users') }}' + '/edit/' + row.id + '">' + row.user_name + '</a>';
                        }
                    },
                    {data: 'email'},
                    {data: 'phone'},
                    <?php
                    if(request('role') != 'client')
                    {
                        echo "{data: 'role'},";
                    }
                    ?>
                    {data: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempViewUrl = "{{ route('admin.users.show', ':id') }}";
                            var tempEditUrl = "{{ route('admin.users.edit', ':id') }}";

                            tempViewUrl = tempViewUrl.replace(':id', data);
                            tempEditUrl = tempEditUrl.replace(':id', data);

                            var actions = '';
                            actions += "<a href='" + tempViewUrl + "' class='btn btn-xs btn-default mr-5' target='_blank'><i class='fa fa-eye'></i></a>";
                            actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-default mr-5'><span class='lnr lnr-pencil'></span></a>";
                           <!--  actions += "<button class='btn btn-xs btn-default btn-user-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>"; --> 

                            return actions;
                        }
                    }
                ],
                ajax: "{{ request()->has('role') ? route('admin.users.json', 'role=' . request('role')) : route('admin.users.json', 'role=' . 'client')  }}"
            });

        });
    </script>
    <script>
    $(document).on("click", ".btn-user-delete", function (e) {
        e.preventDefault();
       if (!confirm('Are you sure you want to delete?')) {
                return false;
            }
         var $this = $(this);
       
        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.users.destroy', ':id') }}";
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
                    $('.datatable').DataTable().ajax.reload();
                }
            });
    });
</script>
@endpush