<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model

{
    	protected $fillable = [
		'user_id',
		'product_id',
	];
    public function user(){
        return $this->belongsTo(User::class);


    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function isInWishlist( $productId ) {
		$wishList = Wishlist::where( 'user_id', '=', auth()->id() )
		                    ->where( 'product_id', '=', $productId )->get();

		if ( count( $wishList ) <= 0 ) {
			return false;
		}

		return true;
	}
}
