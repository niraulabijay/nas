@extends('admin.layouts.app')
@section('title', 'Create Page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Create New Page</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('/admin/page') }}">Pages</a></li>
            <li class="active">Create</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                @include('admin.partials.message-success')
                @include('admin.partials.message-error')
            </div>

            {!! Form::open(['route'=>'admin.page.store', 'files' => true, 'class' => '']) !!}
            @include('admin.pages.form', ['submitButtonText' => 'Submit'])
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        jQuery(function () {
            CKEDITOR.replace('content');
        });
    </script>
@endpush