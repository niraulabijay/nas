<a href="{{ route('cart') }}" class="user-cart-link">
    <span>Cart</span>
    <img src="{{ asset('image/cart.png') }}" alt="Cart">
</a>
<div class="user_cart_dd">
    @if(Cart::instance('default')->count())
    <ul class="user_cart_ul">
        @foreach(Cart::content() as $cartContent)
        <li>
            <figure style="float: left; margin-right: 10px; width: 50px;"><img
                        src="{{ asset(getProductImage($cartContent->id, 'small')) }}"
                        alt="{{ $cartContent->name }}"></figure>
            <p class="text-left">
                <span> {{ $cartContent->name }}</span><br>
                <span>{{ $cartContent->qty }}</span> <span>*</span> <span>{{ $cartContent->price }}</span>

            </p>
            <div class="clearfix"></div>
            <hr>
        </li>
        @endforeach
    </ul>
    <div class="cart_subtotal">
        <div class="float-left">Subtotal</div>
        <div class="float-right"><span class=""><span class="">Rs.</span>{{ Cart::instance('default')->total() }}</span>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>
    <a href="{{ route('cart') }}" class="btn  btn-default view-cart float-left">View Cart</a>
    <a href="{{ route('checkout') }}" class="btn btn-danger checkout float-right">Checkout</a>
    <div class="clearfix"></div>
    @else
        <div class="cart-empty">
            <p class="mb-none">No products in cart.</p>
        </div>
    @endif
</div>