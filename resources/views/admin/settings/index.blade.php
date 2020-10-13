@extends('admin.layouts.app')
@section('title', 'Settings')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

	<!-- Content Header (Page header) -->
    {{-- <section class="content-header">
        <h3>Configuration</h3>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Settings</li>
        </ol>
    </section> --}}

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">

                <form action="{{ route('admin.settings.update') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Settings</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                                    <li><a href="#about" data-toggle="tab">About</a></li>
                                    <li><a href="#policy" data-toggle="tab">Policies</a></li>
                                    <li><a href="#social" data-toggle="tab">Social</a></li>
                                    <li><a href="#footer" data-toggle="tab">Footer</a></li>
                                    <li><a href="#seo" data-toggle="tab">SEO</a></li>
                                    <li><a href="#referal" data-toggle="tab">Referal</a></li>
                                    <li><a href="#vcommission" data-toggle="tab">Product Commission</a></li>
                                </ul>
                                <div class="tab-content" style="margin-top: 15px;">
                                    @include('admin.settings.general')
                                    @include('admin.settings.about')
                                    @include('admin.settings.policy')
                                    @include('admin.settings.social')
                                    @include('admin.settings.tax')
                                    @include('admin.settings.footer')
                                    @include('admin.settings.seo')
                                    @include('admin.settings.referal')
                                    @include('admin.settings.product-commission')
                                    
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-danger pull-right">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        jQuery(function () {
            CKEDITOR.replace('who_we_are');
            CKEDITOR.replace('our_mission');
            CKEDITOR.replace('payments');
            CKEDITOR.replace('shipping');
            CKEDITOR.replace('return_policy');
            CKEDITOR.replace('privacy_policy');
            CKEDITOR.replace('terms_conditions');
            CKEDITOR.replace('cancellation');
        });
    </script>
@endpush