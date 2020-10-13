@if(!empty($menu['child']))
@foreach($menu['child'] as $child) 
	<li><a href="{{ $child['link'] }}">{{ $child['label'] }}</a></li>
@endforeach
@endif