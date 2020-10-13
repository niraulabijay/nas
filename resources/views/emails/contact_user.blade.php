@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ url('storage').'/'.getConfiguration('site_logo')}}" alt="" width="150px">
        @endcomponent
    @endslot
    <h2>Thank You For Contacting Us.Your message Has Reached To Us.We Well Contact You Very Soon .If It Is Urgent Please Contact Us At {{getConfiguration('site_primary_phone')}} Or Email at {{getConfiguration('site_primary_email')}}. </h2>
@component('mail::button', ['url' => url('/admin'),'color' => 'red'])
Shop Now
@endcomponent
<hr>
 <h2> Message Details</h2>
<table class="table" >
    <tbody>
    <tr>
<td>
    Name 
</td>
<td>
            {{$content['name']}}
        </td>
    </tr>
<tr>
    Subject
        <td>
            {{$content['subject']}}
        </td>
    </tr>
    <tr>
        <td>
            Phone 
        </td>
        <td>
            {{$content['phone']}}
        </td>
    </tr>
 <tr>
        <td>
          Email
        </td>
        <td>
            {{$content['email']}}
        </td>
    </tr>
    <tr>
        <td>
            Message
        </td>
        <td>
           	&nbsp;
 {{$content['message']}}
        </td>
    </tr>
   

    </tbody>


</table>

@slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent



