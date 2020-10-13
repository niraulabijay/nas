@extends('admin.layouts.app')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <section>
        <div class="row">
            <h3 class="text-center">Edit Slideshow</h3>
            {!! Form::model($slideshow, ['route' => ['admin.slideshow.update', $slideshow->id], 'method' => 'POST', 'files' => true, 'class' => '']) !!}
                @include('admin.slideshow.form', ['submitButtonText' => 'Update'])
            {!! Form::close() !!}
        </div>
    </section>
@endsection

