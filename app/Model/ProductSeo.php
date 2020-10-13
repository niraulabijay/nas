<?php

namespace App\Model;

use App\Model\Product;
use Illuminate\Database\Eloquent\Model;

class ProductSeo extends Model
{
     
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'product_id',
            'meta_keyword',
            'meta_description',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
