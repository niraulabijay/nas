@extends('admin.layouts.app')
@section('title', 'All Pages')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Pages
            <small>({{ $pagesCount }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pages</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                @include('admin.partials.message-success')
                @include('admin.partials.message-error')

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="display:inline-block;">All Pages</h3>
                        <a href="{{ route('admin.page.create') }}" style="margin-left:10px;">Add New</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Created at</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Created at</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
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
            $('.datatable').DataTable({
 aaSorting: [[0, 'desc']],
             
                processing: true,
                serverSide: true,
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            var pageEditUrl = "{{ route('admin.page.edit', ':id') }}";

                            pageEditUrl = pageEditUrl.replace(':id', data);
                            return '<a href="' + pageEditUrl + '">#' + data + '</a>';
                        }
                    },
               
                    {
                        data: 'name',
                        render: function (data, type, row) {
                            return '<a href="{{ url('/admin/page') }}' + '/' + row.id + '/edit' + '">' + data + '</a>';
                        }
                    },
                    {data: 'slug', name: 'slug'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempEditUrl = "{{ route('admin.page.edit', ':id') }}";
                            var tempDeleteUrl = "{{ route('admin.page.destroy', ':id') }}";

                            var tempViewUrl = "{{ url('/') }}" + "/" + row.slug;
                            tempEditUrl = tempEditUrl.replace(':id', data);
                            tempDeleteUrl = tempDeleteUrl.replace(':id', data);

                            var actions = '';
                            actions += "<a href='" + tempViewUrl + "' class='btn btn-xs btn-warning' target='_blank'><span class='lnr lnr-eye'></span></a>";
                            actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-info'><span class='lnr lnr-pencil'></span></a>";
                            
                            
                            actions += "<form action='" + tempDeleteUrl + "' method='post' style='display: inline-block;'>";
                            
                            actions += "<input type='hidden' name='_token' value='{{ csrf_token() }}'>";
                            
                            actions += "<input type='hidden' name='_method' value='DELETE'>";
                            
                            actions += "<button type='submit' class='btn btn-xs btn-danger'><span class='lnr lnr-trash'></span></button>";
                            
                            actions += "</form>";

                            return actions;
                        }
                    }
                ],
                ajax: '{{ route('admin.pages.json') }}'
            });
        });
    </script>
@endpush