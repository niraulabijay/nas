@extends('admin.layouts.app')
@section('title', 'Menulist')

<style>
	 ul.parent-list li:hover > ul
	{
		display: block !important;
	}

	.all-menus ul li.parent
	{
		position: relative;
		border-bottom: 1px solid #ccc; 
		font-size: 15px;
		padding: 5px 20px;
	}

	.all-menus ul>li>ul
	{
		width: 200px;
		position: absolute;
		left: 100%;
		top: 0;
		display: none;
		z-index: 999;
		padding: 0;
		margin: 0;
	}

	.all-menus
	{
		padding: 0 !important;
	}

	.all-menus ul.parent-list
	{
		list-style: none;
		margin: 0;
		padding: 0;
	}

	.all-menus ul>li>ul>li
	{
		font-size: 13px;
		padding: 5px 20px;
		border-bottom: 1px solid #ccc;
	}
</style>

@section('content')
	<section>
		<div class="row">
			<div class="col-xs-3">
				<h3>All Menus</h3>
				<div class="content__box content__box--shadow all-menus">
					<ul class="parent-list">
						@foreach ($menulist as $menu)
							<li class="parent">{{ $menu->label }}
								{{-- <div class="sub-menu-list content__box content__box--shadow"> --}}
									@include('admin.menu.menu', ['menu' => $menu])
								{{-- </div> --}}
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</section>
@endsection