
@if($category->subCategory->isNotEmpty())
	@foreach($category->subCategory as $child)
		 <option value="{{ $child->id }}">
           &nbsp;&nbsp;{{seperator($loop->depth)}}&nbsp;&nbsp;{{ $child->name }}</option>
            @include('admin.category.dropdown', ['category' => $child])
	@endforeach
@endif
