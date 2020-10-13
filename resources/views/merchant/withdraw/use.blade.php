@extends('merchant.layouts.app')
@section('title',"Withdraw")
@section('content')
    <section>
        <div class="content__box content__box--shadow">
            <div class="row">
                <h3>Withdraw Account Information</h3>
                @foreach($details->unique('account_no') as $detail)
                <div class="col-lg-4 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div class="huge">{{ $detail->method }}</div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Account Name</th>
                                        <td>{{ $detail->account_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Account Number</th>
                                        <td>{{ $detail->account_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Account Status</th>
                                        <td>
                                            @if( $detail->approve == 1 )
                                                <span class="btn btn-primary btn-xs">Verify</span>
                                            @else
                                                <span class="btn btn-danger btn-xs">Non-Verify</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                </table>
                            </div>
                        </div>
                        <a href="{{ route('vendor.withdraw.use',[$detail->id]) }}">
                            <div class="panel-footer"><span class="pull-left">Use this Account</span><span class="pull-right"><svg class="svg-inline--fa fa-arrow-circle-right fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="arrow-circle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm-28.9 143.6l75.5 72.4H120c-13.3 0-24 10.7-24 24v16c0 13.3 10.7 24 24 24h182.6l-75.5 72.4c-9.7 9.3-9.9 24.8-.4 34.3l11 10.9c9.4 9.4 24.6 9.4 33.9 0L404.3 273c9.4-9.4 9.4-24.6 0-33.9L271.6 106.3c-9.4-9.4-24.6-9.4-33.9 0l-11 10.9c-9.5 9.6-9.3 25.1.4 34.4z"></path></svg><!-- <i class="fa fa-arrow-circle-right"></i> --></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
        <a href="{{ route('vendor.withdraw.request') }}" class="btn btn-default">Create New Withdraw</a>
    </section>

@endsection
