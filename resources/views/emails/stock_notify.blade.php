@component('mail::layout')
    {{-- Header --}}
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        <img src="{{ url('storage').'/'.getConfiguration('site_logo')}}" alt="" width="150px">
    @endcomponent
@endslot

#Dear Customer,<br>
The product "<strong>{{ $content['name'] }}</strong>" you want to buy is now available in Nepal All Shop.
You can now buy this item from Nepal All Shop.
	
@component('mail::button', ['url' => route('product.show', $content['slug']), 'color' => 'red'])
	Buy Now
@endcomponent

@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endslot
@endcomponent
