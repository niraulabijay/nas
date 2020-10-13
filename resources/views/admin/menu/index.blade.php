@extends('admin.layouts.app')
@section('title', 'Category')

@section('content')
	<section>
		<div class="row">
			<h3 class="text-center">Menus</h3>
			<div class="col-xs-12">
				<div class="content__box content__box--shadow">
					{!! Menu::render() !!}
				</div>
			</div>
		</div>
	</section>
@endsection

@push('scripts')
    {!! Menu::scripts() !!}
@endpush