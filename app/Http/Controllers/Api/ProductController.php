<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use App\Model\Wishlist;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->get();
        return new ProductCollection($products);
    }

    public function show(Product $product)
    {
    	$product->view= $product->view+1;
        $product->update();
        return new ProductResource($product);
    }

    public function checkWishlist($id)
    {
        $wishlist = Wishlist::where( 'user_id', '=', auth()->id() )
                            ->where( 'product_id', '=', $id )->first();
        if(isset($wishlist))
        {
            return response()->json(['status' => 1]);
        }
        else
        {
            return response()->json(['status' => 0]);
        }
    }

    public function checkStock($id)
    {
        $product = Product::find($id);
        return response()->json(['stock_quantity' => $product->stock_quantity]);
    }
}
