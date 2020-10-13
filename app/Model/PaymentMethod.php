<?php

namespace App\Model;

use App\Concern\Mediable;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use Mediable;
    protected $fillable = [
        'name',
        'company_name'
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
}
