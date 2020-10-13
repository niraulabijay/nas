@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ url('storage').'/'.getConfiguration('site_logo')}}" alt="" width="150px">
        @endcomponent
    @endslot
    <h4>Dear {{$content['name']}}, Your Request To Be {{ getConfiguration('site_title') }} Merchant Has Been {{$content['status']}}</h4>
    You can now upload your products and start selling and get orders.

    @component('mail::button', ['url' => url('/'),'color' => 'red'])
    Visit our store
    @endcomponent

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
