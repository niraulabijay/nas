<div class="alert__section" style="padding: 10px 10px 0 10px;">
    <div class="row">
        @if(Session::has('success'))
        <div class="col-md-12">
            <div class="alert alert-info">
                <strong>Success!</strong> {{ Session::get('success') }}.
                <button type="button" class="close alert--close"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        </div>
        @endif
        @if(count($errors))
            <div class="alert alert-danger">
                <strong>Whoops!</strong>
                <br/>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>