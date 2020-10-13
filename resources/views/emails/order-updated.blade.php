@component('mail::layout')
    {{-- Header --}}
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        <img src="{{ url('storage').'/'.getConfiguration('site_logo')}}" alt="" width="150px">
    @endcomponent
@endslot
<h3> Your  Order #{{$content['id']}} has been {{$content['value']}}, Please check the following link for details </h3>
@component('mail::button', ['url' => route('user.account') ,'color' => 'red'])
    Details
@endcomponent

<div style="display: inline-block"> Or <a href="{{url('/')}}">Visit Our Store</a></div>

@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endslot
@endcomponent
