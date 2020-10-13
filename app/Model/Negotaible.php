<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Negotaible extends Model
{

    protected $fillable = [
        'user_id',
        'product_id',
        'fixed_price',
        'ordered'
    ];

    public  function  price(){
        return $this->hasMany(NegotiablePrice::class);
    }
    public  function  product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public  function  user(){
        return $this->belongsTo(User::class);
    }
    public function negotiableMessages()
    {
        return $this->hasMany(NegotiablePrice::class,'negotiable_id');
    }

}
