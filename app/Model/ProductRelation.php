<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductRelation extends Model
{
    protected $fillable = ['product_id', 'relation_id'];

    public function products()
    {
    	return $this->belongsTo(Product::class, 'product_id');
    }

    public function relations()
    {
    	return $this->belongsTo(Product::class, 'relation_id');
    }
}
