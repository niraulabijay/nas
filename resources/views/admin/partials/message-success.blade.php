<style>
	.alert-message{
		display: none;
		margin-top: 10px;
	}
</style>

@if (Session::has('success'))
    <div class="alert alert-success alert-message">
        {!! session('success') !!}
    </div>
@endif
