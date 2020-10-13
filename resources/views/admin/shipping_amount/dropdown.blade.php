
@if($area->subCategory->isNotEmpty())
	@foreach($area->subCategory as $child)
		 <option value="{{ $child->id }}">
           &nbsp;&nbsp;{{seperator($loop->depth)}}&nbsp;&nbsp;{{ $child->name }}</option>
            @include('admin.shipping_amount.dropdown', ['area' => $child])
	@endforeach
@endif
