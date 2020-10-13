@extends('admin.layouts.app')

@section('content')
	<section>
		<div class="row">
			<div class="col-xs-12" id="test">
				<h3>Edit Testimonial</h3>
				{!! Form::model($testimonials, ['method' => 'POST', 'files' => true, 'id' => 'testimonialUpdate']) !!}
				@include('admin.testimonials.form', ['submitButtonText' => 'Update'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@endsection

@push('scripts')
<script>
	$(document).on("click", ".btn-testimonial-update", function (e) {
        e.preventDefault();
        var params   = $('#testimonialUpdate').serializeArray();
        console.log(params);
            var formData = new FormData($('#testimonialUpdate')[0]);
            if($('#image').val()) {
                formData.append('image', $('input[type=file]')[0].files[0]);
            }

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
                url: "{{ route('admin.testimonials.update', $testimonials->id) }}",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                beforeSend: function (data) {
                },
                success: function (data) {
                	window.location.href = "{{ route('admin.testimonials.index') }}";
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
                	
                }
            });
    });
</script>
@endpush