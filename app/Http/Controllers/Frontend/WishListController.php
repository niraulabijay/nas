<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Product;
use App\Model\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where([
            'user_id' => auth()->id()
        ])->get();
        return view('front.my_account.index', compact('wishlists'));
    }

    public function store(Request $request)
    {
        if (auth()->guest()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You must login first'
            ], 401);
        }
        $productId = $request->input('product');
        $wishlist = new Wishlist();

        if ($wishlist->isInWishlist($productId)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product has been added to your wishlist!!'
            ], 200);
        }

        $product = Product::findOrFail($productId);
        $wishlist->create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Product has been added to your wishlist!!'
        ], 201);
    }

    public function getMiniwishlist()
    {
        return view('front.cart.wishlist-update');
    }

    public function gethomeremove()
    {
        return view('front.wishlist.removewishlist');
    }
    public function delete(Request $request)
    {
        $productId = $request->input('product');
        Wishlist::where([
            'user_id' => auth()->id(),
            'product_id' => $productId,
        ])->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product Remove From Your Wishlist!!'
        ], 200);
    }

    public function destroy($productId)
    {
        Wishlist::where([
            'user_id' => auth()->id(),
            'product_id' => $productId,
        ])->delete();
        Session::flash('success', "Product removed from your wishlist!!");
        return redirect()->back();
    }

}
