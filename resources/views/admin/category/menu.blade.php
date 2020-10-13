@foreach($cat->subCategory as $sub)
	<ul>
		<li>{{ $sub->name }}</li>
		@include('admin.category.menu',['cat' => $sub])
	</ul>
@endforeach