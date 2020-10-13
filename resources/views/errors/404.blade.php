@extends('layouts.app')
@section('content')
<div class="container">
    <div style="margin: 100px;">
        <div class="alert alert-info">
            <h2  class="text-center">@isset($message) {{ $message }} @else 404 !
                <br>
                @php
                    $currentRoute = Route::currentRouteName();
                @endphp
                The @if($currentRoute == 'product.show')Product  @else Page @endif  you have requested could not be found
                @endisset  </h2>
        </div>

    </div>
</div>

@endsection