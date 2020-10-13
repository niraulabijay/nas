<?php

namespace App\Http\Resources\Product;

use App\Model\Product;
use App\Model\ProductRelation;
use App\Model\VendorDetail;
use App\Model\Wishlist;
use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        foreach ($this->images as $image) {
            $images[] = $image->path;
        }
        $sizes  = $this->additionals->pluck('size')->toArray();

        $shop= VendorDetail::where('user_id', $this->user_id)->first();
        $shop_name = $shop ? $shop->name : 'Nepal All Shop';

        $categories = $this->categories()->get()->pluck( 'id' )->toArray();
        $similarProducts = Product::whereHas( 'categories', function ( $query ) use ( $categories ) {
            $query->whereIn( 'categories.id', $categories );
        } )->whereNotIn( 'name', [ $this->name ] )->where('status','published')->take( 20 )->get();

        foreach ($similarProducts as $similarProduct) {
            $similarProduct->img = $similarProduct->getImageAttribute()->mediumUrl;
        }

        $wishlist = Wishlist::where( 'user_id', '=', auth()->id() )
                            ->where( 'product_id', '=', $this->id )->first();

        $relation = $this->relation->product_id;
        $relation_ids = ProductRelation::where('product_id', $relation)->pluck('relation_id')->toArray();
        $related_products = Product::whereIn('id', $relation_ids)->where('status','published')->get();
        $i = 0;
        foreach ($related_products as $related_product) {
            $relatedProducts[$i]['id'] = $related_product->id;
            $relatedProducts[$i]['color'] = $related_product->color;
            $relatedProducts[$i]['image'] = $related_product->getImageAttribute()->smallUrl;
            $i++;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'product_price' => $this->product_price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
            'stock_quantity' => $this->stock_quantity,
            'from' => $this->from,
            'to' => $this->to,
            'tax' => $this->tax != null ? $this->tax : 0,
            'prebooking' => $this->prebooking,
            'images' => $images,
            'sizes' => array_unique($sizes),
            'shop_name' => $shop_name,
            'specifications' => $this->specifications,
            'features' => $this->features,
            'similarProducts' => $similarProducts,
            'wishlist' => isset($wishlist) ? 1 : 0,
            'related_products' => $relatedProducts
        ];
    }
}
