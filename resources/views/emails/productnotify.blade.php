@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ url('storage').'/'.getConfiguration('site_logo')}}" alt="" width="150px">
        @endcomponent
    @endslot

    Dear Admin,<br>
    You have received a product request from Vendor, "<strong> {{ $content['first_name'] }} {{ $content['last_name'] }}</strong>".
    He/She has added a new product named "<strong>{{ $content['name'] }}</strong>" with price of "<strong>Rs.{{ $content['price'] }}</strong>".<br>
    <strong>
       <u>Vendor Information:</u><br>
        Name : {{ $content['first_name'] }} {{ $content['last_name'] }} <br>
        Email: {{ $content['email'] }}<br>
        Phone: {{ $content['phone'] }}<br>
    </strong>


    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
