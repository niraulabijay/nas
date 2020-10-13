@extends('admin.layouts.app')
@section('title', 'Commissions')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')
    <section>
        <div class="row">
            <h3>Commission Settings</h3>
            <div class="col-sm-6 ">
                <div class="content__box content__box--shadow">
                <table class="table table-striped table-hover" id="commissionTable1">
                    <thead>
                    <tr>
                        <th>Vendor</th>
                        <th>Commission (%)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vendors as $vendor)
                        <form action="{{ route('admin.commission.update') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                            <tr>
                                <td>{{ $vendor->name }}</td>
                                <td>
                                    <div class="@if ($errors->has('commission')) has-error @endif">
                                    <input type="text" name="commission" class="form-control">
                                    @if ($errors->has('commission'))
                                        <span class="help-block">
                                            {{ $errors->first('commission') }}
                                        </span>
                                    @endif
                                    </div>
                                </td>
                                <td><button type="submit" class="btn btn-default btn-xs"><span class="fa fa-plus"></span></button></td>
                            </tr>
                        </form>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="col-sm-6 ">
                <div class="content__box content__box--shadow">
                <table class="table table-striped table-hover" id="commissionTable2">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Vendor</th>
                        <th>Commission (%)</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($commissions as $commission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \App\User::where('id', $commission->user_id)->first()->name }}</td>
                            <td>{{ $commission->commission }}</td>
                            <td>
                                <a href="{{ route('admin.commission.edit', $commission->user_id) }}" class="btn btn-default btn-xs"><span class="lnr lnr-pencil"></span></a>
                                <a href="{{ route('admin.commission.delete', $commission->id) }}" class="btn btn-default btn-xs"><span class="lnr lnr-trash"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
//    $(document).ready(function () {
//        $('#commissionTable1').DataTable({
//            "columnDefs": [
//                { "orderable": false, "targets": 1 },
//                { "orderable": false, "targets": 2 }
//            ]
//        });
//    })

    $(document).ready(function () {
        $('#commissionTable2').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": 3 }
            ]
        });
    })
</script>
@endpush