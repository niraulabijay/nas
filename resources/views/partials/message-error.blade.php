@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible">
        {!! session('error') !!}
    </div>
@endif