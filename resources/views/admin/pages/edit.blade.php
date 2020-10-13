@extends('admin.layouts.app')
@section('title', 'Edit Page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Page</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="{{ url('/admin/page') }}">Pages</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                @include('admin.partials.message-success')
                @include('admin.partials.message-error')
            </div>

            {!! Form::model($page, ['method' => 'PATCH', 'files' => true, 'action' => ['Backend\PageController@update', $page->id], 'class' => '']) !!}
            @include('admin.pages.form', ['submitButtonText' => 'Update'])
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