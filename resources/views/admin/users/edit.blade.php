@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <h3>Edit User</h3>
            <div class="col-md-12">

                <div class="content__box content__box--shadow">
                    {!! Form::model($user, ['method' => 'PATCH', 'files' => true, 'action' => ['Backend\UserController@update', $user->id], 'class' => 'form-horizontal']) !!}
                    @include('admin.users.form', ['submitButtonText' => 'Update'])
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