<?php

namespace App\Http\Resources\Account;

// use function foo\func;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $subTotal = 0.0;
        $tax = 0.0;
        $discount = 0.0;
        foreach ($this->products as $order_product) {
            $qty = $order_product->pivot->qty;
            $price = $order_product->pivot->price;
            $img = $order_product->getImageAttribute()->smallUrl;
            $actualPrice = $qty * $price;
            if($order_product->pivot->prebooking == 1) {
                $subTotal += ($actualPrice * 10) / 100;
                $tax += 0;
            }
            else {
                $subTotal += $actualPrice;
                $tax += ($actualPrice * $order_product->tax) / 100;
            }
            $order_product->pivot->name = $order_product->name;
            $discount += $order_product->pivot->discount;
            $pivot = array_add($order_product->pivot, 'total', $actualPrice);
            $pivots[] = array_add($pivot, 'img', $img);
        }

        $grandTotal = $subTotal + $tax + $this->shipping_amount - $discount;

        return [
            'id' => $this->id,
            'order_status' => $this->orderStatus->name,
            'order_date' => $this->order_date->format('Y-m-d h:i:s'),
            'orderProducts' =>  isset($pivots) ? $pivots : '',
            'subtotal' => $subTotal,
            'tax' => $tax,
            'discount' => $discount,
            'shipping_amount' => $this->shipping_amount,
            'grandtotal' => $grandTotal,
        ];
    }
}
