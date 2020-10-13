@extends('admin.layouts.app')

@section('title', 'Team')

@section('content')
	<section>
		<div class="row">
			<h3 class="text-center">Add New Member</h3>
			{!! Form::open(['files' => true, 'class' => '', 'id' => 'teamSubmit']) !!}
            @include('admin.team.form', ['submitButtonText' => 'Submit'])
            {!! Form::close() !!}
		</div>
	</section>
@endsection

@push('scripts')
<script>
	$(document).on("click", ".btn-team-add", function (e) {
        e.preventDefault();
            var params   = $('#teamSubmit').serializeArray();
            var formData = new FormData($('#teamSubmit')[0]);
                formData.append('image', $('input[type=file]')[0].files[0]);

            $.each(params, function(i, val) {
                formData.append(val.name, val.value);
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('admin.team.store')  }}",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                beforeSend: function (data) {
                },
                success: function (data) {
                    $(".alert-success").fadeTo(5000, 5000).html(data).slideUp(500, function() {
                        $("#alert").slideUp(5000);
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorsHolder = '';
                    errorsHolder += '<ul>';

                    var err = eval("(" + xhr.responseText + ")");
                    $.each(err.errors, function (key, value) {
                        errorsHolder += '<li>' + value + '</li>';
                    });


                    errorsHolder += '</ul>';

                    $(".alert-danger").fadeTo(5000, 5000).html(errorsHolder).slideUp(500, function() {
                        $("#alert").slideUp(5000);
                    });
                },
                complete: function () {
                	 $("#teamSubmit")[0].reset(),
                	$('#teamsTable').DataTable().ajax.reload();
                }
            });
    });
</script>
@endpush