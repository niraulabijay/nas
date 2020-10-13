<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderReturnStatus extends Model
{
    protected $fillable = [ 'name', 'is_default' ];
    protected $table = 'order_return_statuses';

    public function orderReturn() {
        return $this->hasMany( OrderReturnRequest::class );
    }
}
