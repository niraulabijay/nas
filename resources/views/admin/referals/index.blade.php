@extends('admin.layouts.app')
@section('title', 'Referral')

@section('content')
    <section>
        <div class="row">
            <h3>All Referrals</h3>
            <div class="col-sm-12 content__box content__box--shadow">
                <table class="table table-striped table-hover" id="referalTable">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#referalTable').DataTable({
            aaSorting: [0,'desc'],
            processing: true,
            serverSide: true,
            columns: [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'sender_id',
                    render: function (data, type, row) {
                        return '<a href="">'+ data +'</a>';
                    }
                },
                {data: 'receiver_id',
                    render: function (data, type, row) {
                        return '<a href="">'+ data +'</a>';
                    }
                },
                {data: 'amount', name: 'amount'},
                {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                        var actions = '';
                        actions += "<button type='submit' class='btn btn-xs btn-danger referal-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>";

                        return actions;
                    }
                }
            ],
            ajax: '{{route('admin.referal.json')}}'
        });
    });

    $(document).on("click", ".referal-delete", function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete?')) {
            return false;
        }
        var $this = $(this);

        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.referal.delete', ':id') }}";                               tempDeleteUrl = tempDeleteUrl.replace(':id', id);


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
                console.log(data);
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
                $('#referalTable').DataTable().ajax.reload();
            }
        });
    });
</script>
@endpush