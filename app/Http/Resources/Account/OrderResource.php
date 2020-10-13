<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_date' => $this->order_date,
            'order_status' => $this->orderStatus->name,
            'order_note' => $this->order_note,
            'orderProducts' => $this->products,
            'shippingAddress' => $this->shipping_address
        ];
    }
}
