<style>
	.alert-message{
		display: none;
		margin-top: 10px;
	}
</style>

@if (Session::has('error'))
    <div class="alert alert-danger alert-message">
        {!! session('error') !!}
    </div>
@endif