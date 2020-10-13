@if(!empty($menu['child']))
@foreach($menu['child'] as $child)
    <li class="has-children">
        <a href="{{ $child['link'] }}" class="">{{ $child['label'] }}</a>
        <ul class="is-hidden liststyle--none">
            @include('partials.sub-menu', ['menu' => $child])
        </ul>
    </li>
@endforeach
@endif