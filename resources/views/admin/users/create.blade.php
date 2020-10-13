@extends('admin.layouts.app')
@section('title', 'Add User')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <h3>Add User</h3>
            <div class="col-md-12">

                <div class="content__box content__box--shadow">
                    <div class="box-header with-border">
                    {!! Form::open(['method' => 'POST', 'files' => true, 'action' => ['Backend\UserController@store'], 'class' => 'form-horizontal']) !!}
                    @include('admin.users.form', ['submitButtonText' => 'Submit'])
                    {!! Form::close() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')

@endpush