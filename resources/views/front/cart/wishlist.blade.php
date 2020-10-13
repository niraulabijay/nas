@extends('layouts.app')
@section('title', 'Cart')

@section('content')
    <section class="cartpage-container uk-margin-bottom">
        <div class="my-container">
            <section class="row breadcrumbs max-inner">
                <div class="columns col-12">
                    <ul class="breadcrumb-list">
                        <li>Wishlist</li>
                    </ul>
                </div>
            </section>


            @php
                $user=Auth::user();
                $wishlists= $user->wishlists;
            @endphp
            @if($wishlists && $wishlists->count())
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post">
                            <table class="uk-table uk-table-divider shop_table" cellspacing="0">
                                <thead class="hidden-xs">
                                <tr>
                                    <th class="product-thumbnail">S/N</th>
                                    <th class="product-thumbnail">&nbsp;</th>
                                    <th class="product-name span">Product</th>
                                    <th class="product-price" style="color:#ffffff">Price</th>
                                    <th class="product-quantity">Availability</th>
                                    <th class="product-quantity">Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                @if($wishlists)
                                    @foreach($wishlists as $wishlist)
                                        <tr class="cart_item">
                                            <td class="product-thumbnail hidden-xs">
                                                <strong>
                                                    #{{$loop->index +1}}
                                                </strong>
                                            </td>
                                            <td class="product-thumbnail ">
                                                <a href="{{ route('product.show', ['slug' => $wishlist->product->slug]) }}">
                                                    <img src="{{ asset(getProductImage($wishlist->product_id, 'small')) }}"
                                                         class=" "
                                                         style="height: auto;width: 100px;">
                                                </a>
                                            </td>
                                            <td class="product-name  hidden-xs" data-title="{{ $wishlist->product->name }}">
                                                <a href="{{ url('/product/'.$wishlist->product->slug) }}">{{ $wishlist->product->name }}</a>
                                            </td>
                                            <td class="product-price" data-title="Price">
                                            <span class="amount">
                                                <span class="Price-currencySymbol">Rs.</span>
                                                <span class="price">{{$wishlist->product->sale_price}}</span>
                                            </span>
                                            </td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity product-quantitydb">
                                                    <strong>
                                                        {{ $wishlist->product->stock_quantity }} Unit(s) Stock
                                                    </strong>
                                                </div>
                                            </td>
                                            <td class="product-remove ">
                                                <a href="javascript:void(0)" data-row="{{ $wishlist->id }}" data-product="{{ $wishlist->product->id }}"
                                                   class="remove btn-remove-row remove_from_wishlist"
                                                   title="Remove {{$wishlist->product->name}} from wishlist">x</a>
                                            </td>

                                        </tr>

                                    @endforeach
                                @else
                                    <div class="text-center">
                                        Your Wishlist is empty!
                                    </div>
                                @endif
                                </tbody>

                            </table>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            @else
                <div class="uk-alert-success" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>There is no items in your wishlist.</p>
                </div>
                <div class="text-center">
                    <a href="{{ url('/') }}" class="btn btn-sm btn-success">Back to Home</a>
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
                    UpdateMiniCart();
                }
            });

        });

    </script>

@endsection