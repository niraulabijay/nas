@extends('admin.layouts.app')
@section('title', 'Edit Seo')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <section>
        <div class="row">
            <h3 class="text-center">Edit Seo</h3>
            {!! Form::model($seo, ['route' => ['admin.seo.update', $seo->id], 'method' => 'PATCH', 'files' => true, 'class' => '']) !!}
                @include('admin.seos.form', ['submitButtonText' => 'Update'])
            {!! Form::close() !!}
        </div>
    </section>
@endsection

