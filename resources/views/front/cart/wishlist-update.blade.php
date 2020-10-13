<span id="top-cart-wishlist-count" class="value">
    @if( Auth::user() )
        {{ App\Model\Wishlist::where('user_id', Auth::User()->id)->count() }}
    @endif
</span>