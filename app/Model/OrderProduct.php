<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected  $table='order_product';

    public function products() {
        return $this->belongsTo( Product::class , 'product_id');
    }

    public  function  order(){
        return $this->belongsTo( Order::class );

    }

    public function disputes()
    {
        return $this->belongsTo(Dispute::class);
    }

    public function orderReturnProducts()
    {
        return $this->belongsTo(OrderReturnRequestProduct::class);
    }
}
