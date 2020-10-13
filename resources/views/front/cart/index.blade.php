@extends('layouts.app')
@section('title', 'Cart')

@section('content')

<section id="shopping-cart">
    <div class="container box-shadow mt-2 mb">
        <h1>Shopping Cart</h1>
        @if(Cart::instance('default')->count())
        <div class="shopping-cart">

            <div class="column-labels">
                <label class="product-image text-center">Image</label>
                <label class="product-details">Product</label>
                <label class="product-price">Price</label>
                <label class="product-quantity">Quantity</label>
                <label class="product-removal">Remove</label>
                <label class="product-line-price">Total</label>
            </div>
            @php
                $subTotal = 0;
                $tax = 0;
                $grandTotal = 0;
            @endphp
            @if(Cart::count() != 0)
                @foreach(Cart::instance('default')->content() as $cartContent)
                    <div class="product cart_item">
                        <div class="product-image">
                            <img src="{{ asset(getProductImage($cartContent->id, 'small')) }}">
                        </div>
                        <div class="product-details">
                            <div class="product-title">{{$cartContent->name}}</div>
                            <p class="product--description">
                                {{-- <span class="product--details">
                                    Colour:{{$cartContent->colour}}
                                </span>
                                <br> --}}
                                <span class="product--size">
                                    {{$cartContent->options->size ? 'size:' . $cartContent->options->size : '' }}
                                </span>
                                <span class="clearfix"></span>
                            </p>
                        </div>
                        <div class="product-price">{{$cartContent->price}}</div>
                        <div class="product-unitprice" style="display: none;">{{ \App\Model\Product::where('id',$cartContent->id)->first()->tax }}</div>
                        <div class="product-quantity product-quantitydb">
                            <input type="number" class="form-control" data-product="{{$cartContent->rowId}}" value="{{ $cartContent->qty }}" min="1" max="{{\App\Model\Product::where('id',$cartContent->id)->first()->stock_quantity}}">
                        </div>
                        <div class="product-removal product-remove">
                            <button class=" btn btn-danger remove-product btn-remove-row remove" data-row="{{ $cartContent->rowId }}">
                               <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <div class="product-line-price product-subtotal">{{ $cartContent->qty * $cartContent->price + (($cartContent->qty * $cartContent->price) * \App\Model\Product::where('id',$cartContent->id)->first()->tax / 100) }}</div>
                    </div>
                    @php
                        $subTotal += $cartContent->qty * $cartContent->price;
                        if (\App\Model\Product::findOrFail($cartContent->id)->tax) {
                            $tax += (($cartContent->qty * $cartContent->price) * (\App\Model\Product::where('id',$cartContent->id)->first()->tax)) / 100;
                        }
                            $grandTotal = $subTotal + $tax;
                    @endphp
                @endforeach
            @else
                <div class="text-center">
                    Your cart is empty!
                </div>
            @endif

            @if(Cart::count() != 0)
                <div class="coupon">
                    <div class="float-right">
                        <form action="{{ route('coupon.check') }}" method="post">
                            {{ csrf_field() }} 
                            @foreach(Cart::instance('default')->content() as $cartContent)
                            <input type="hidden" name="product_id[]" value="{{ $cartContent->id }}">
                            @endforeach
                            <input type="text" name="coupon_code" class="coupon_code uk-input" id="coupon_code_text"
                                   placeholder="Coupon code">
                            <input type="submit" class="btn-primary uk-button view-cart coupon_btn float-right my-2" name="apply_coupon"
                                   value="Apply Coupon">
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                </div>
            @endif

            <div class="totals">
                <div class="totals-item">
                    <label>Subtotal</label>
                    <div class="totals-value totals_value" id="subtotal">{{ number_format($subTotal, 2) }}</div>
                </div>
                <div class="totals-item">
                    <label>Tax</label>
                    <div class="totals-value totals_value" id="cart-tax">{{ number_format($tax, 2) }}</div>
                </div>
                @if(session()->exists('coupon'))
                <div class="totals-item">
                    <label>Discount</label>
                    <div class="totals-value" id="cart-shipping">{{ number_format(session()->get('coupon')['discount_value'], 2) }}</div>
                </div>
                @endif
                <div class="totals-item totals-item-total">
                    <label>Grand Total</label>
                    <div class="totals-value totals_value" id="grandtotal">{{ session()->exists('coupon') ? number_format($grandTotal - session()->get('coupon')['discount_value'], 2) : number_format($grandTotal, 2) }}</div>
                </div>
            </div>

            <a class="btn btn-warning continue" href="{{ route('home.index') }}"> <span uk-icon="icon:chevron-left"></span>Continue Shopping</a>
            <a class="btn btn-danger checkout" href="{{ route('checkout') }}">Checkout</a>
            <div class="clearfix"></div>
        </div>
        @else
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>There is no items in your cart.</p>
            </div>
            <div class="text-center">
                <a href="{{ url('/') }}" class="btn btn-sm btn-success">Back to Shopping</a>
            </div>
        @endif
        <div class="clearfix"></div>
    </div>
</section>

@endsection
@section('extra_scripts')
    <script>

        $(document).on("click", ".btn-remove-row", function (e) {
            e.preventDefault();
            var $this = $(this);

            var rowId = $this.attr('data-row');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('cart/destroy')  }}" + '/' + rowId,
                data: {
                    rowId: rowId
                },
                beforeSend: function () {
                    $this.prop('disabled', true);
                },
                success: function (data) {

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //
                },
                complete: function () {
//                location.reload();
                    UpdateMiniCart();
                    // updateMobileCart();
                }
            });

        });

        $('.product-quantitydb input').change(function () {
            UpdateCart(this);
        });

        function UpdateCart(updateValue) {
            var rowId = $(updateValue).attr('data-product');
            var quantity = $(updateValue).val();var select = document.getElementById("select_size");
            var text = $('#coupon_code_text').val();
            if (select) {
                var size = select.options[select.selectedIndex].value;
            }
            if (document.querySelector('input[name="colour"]:checked')) {
                var colour = document.querySelector('input[name="colour"]:checked').value;
            }
            size = size ? size : 1;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('cart.update') }}",
                data: {
                    rowId: rowId,
                    quantity: quantity,
                    size: size,
                    colour: colour,
                    text: text
                },
                success: function (data) {
                    UpdateMiniCart();
                    // updateMobileCart();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //
                },
                complete: function () {
//                location.reload();

                }
            });
        }

        function UpdateMiniCart() {
            $.ajax({
                type: "GET",
                url: "{{ route('cart.mini')  }}",
                beforeSend: function (data) {
                    //
                },
                success: function (data) {
                    $('#update-cart').html(data);
                    $('#update-minicart').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //
                },
                complete: function () {
                    //
                }
            });
        }
    </script>

@endsection