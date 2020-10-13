@extends('admin.layouts.app')

@section('title', 'Edit Team')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

<!-- Main content -->
    <section class="content">
        <div class="row">
			<h3 class="text-center">Edit Member</h3>
            {!! Form::model($team, ['method' => 'POST', 'files' => true, 'action' => ['Backend\TeamController@update', $team->id], 'class' => '']) !!}
            @include('admin.team.form', ['submitButtonText' => 'Update'])
            {!! Form::close() !!}

        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection