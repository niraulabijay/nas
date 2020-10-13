@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible">
        {!! session('success') !!}
    </div>
@endif