@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ url('storage').'/'.getConfiguration('site_logo')}}" alt="" width="150px">
        @endcomponent
    @endslot

    Dear <strong>{{ $content['first_name'] }} {{ $content['last_name'] }} </strong>,
    Your product "<strong>{{ $content['name'] }}</strong>" has been approved by {{ getConfiguration('site_title') }} <br>
    <br>
    Thank you

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
