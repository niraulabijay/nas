@extends('admin.layouts.app')
@section('title', 'Stock Manager')

@section('content')
	<section>
		<form action="{{ route('admin.products.update') }}" method="post">
			{{ csrf_field() }}
			<div class="row">
				<h3 class="text-center">Stock Manager</h3>
				<div class="col-md-3">
					<label for="product_name">Name</label>
				</div>
				<div class="col-md-3">
					<label for="stock_qty">Stock Quantity</label>
				</div>
				<div class="col-md-3">
					<label for="stock">Stock</label>
				</div>
				<div class="col-md-3">
					<h5>Action</h5>
				</div>
			</div>
			@foreach ($products as $product)
			{{-- <form action="" id="stockform" method="post">
				{{ csrf_field() }} --}}
				{{ method_field('PUT') }}
				<div class="row">
				<input type="hidden" name="id" id="id" value="{{ $product->id }}">
					<div class="col-md-3">
						<h5><a href="">{{ $product->name }}</a></h5>
					</div>
					<div class="col-md-3">
						<input type="text" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}">
					</div>
					<div class="col-md-3">
						<select name="stock" id="stock" class="form-control">
							<option value="1" @if($product->stock == 1) selected @endif>In Stock</option>
							<option value="0" @if($product->stock == 0) selected @endif>Out Stock</option>
						</select>
					</div>
					<div class="col-md-3">
						<button type="submit" name="submit" class="btn btn-primary btn-sm btn-stock">Edit</button>
					</div>
				</div>
			{{-- </form> --}}
			@endforeach
				<!--<button type="submit" name="submit" class="btn btn-danger btn-sm pull-right" onclick="return submitForm();">Update</button>-->
		</form>
		{{ $products->links() }}
	</section>
@endsection

@push('scripts')
<script>
	function submitForm(form){
    var url = form.attr("action");
    var formData = $(form).serializeArray();
    $.post(url, formData).done(function (data) {
        alert(data);
    });
}

$(document).on('click','.btn-stock',function(e){
    e.preventDefault(e);
        var stock_quantity = $(this).parent().parent().find('#stock_quantity').val();
        var id = $(this).parent().parent().find('#id').val();
        var stock = $(this).parent().parent().find('#stock').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({

        type:"POST",
        url:'{{ route('admin.products.update') }}',
        data: {'id': id, 'stock_quantity': stock_quantity, 'stock': stock},
        success: function(data){
            window.location.reload();
        },
        error: function(data){

        }
    })
    });
</script>
@endpush