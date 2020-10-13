@extends('merchant.layouts.app')
@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hovered" id="vendor-bank-info">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Bank Name</th>
                    <th>Account Holder</th>
                    <th>Account Number</th>
                    <th>Created Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#vendor-bank-info').DataTable({
               aaSorting: [0,'desc'],
               processing: true,
               serverSide: true,
               columns: [
                   {
                       "data": "id",
                       render: function(data,type,row,meta){
                           return meta.row + meta.settings._iDisplayStart + 1;
                       }
                   },
                   {
                       data:'bank_name',
                       name:'bank_name'
                   },
                   {
                       data:'account_holder',
                       name:'account_holder'
                   },
                   {
                       data:'account_number',
                       name:'account_number'
                   },
                   {
                       data:'date',
                       name:'date'
                   },
                   {
                        data:'id',
                       orderable:false,
                       render: function (data,type,row) {
                           var actions = '';
                           actions += "<button type='submit' class='btn btn-xs btn-info btn-view' data-id=" + row.id + "><i class=\"fas fa-check-circle\"></i>Remove</button>";

                           return actions;
                       }
                   }
               ],
                ajax: '{{ route('admin.vendor-bank-info.json') }}'
            });
        });
    </script>
@endpush