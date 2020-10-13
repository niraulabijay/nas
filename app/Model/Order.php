<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'address_id',
        'user_id',
        'payment_method_id',
        'shipping_amount',
        'order_status_id',
        'order_place',
        'order_note',
        'order_date',
        'code',
        'tracking',
        'delivery_destination_id',
        'invoice_date',
        'barcode'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'order_date',
        'created_at',
        'updated_at'
    ];

    public function orderStatus()    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function products() {
        return $this->belongsToMany( Product::class )
            ->withPivot( 'qty', 'price', 'tax', 'discount', 'prebooking', 'colour', 'size', 'id', 'status' )
            ->withTimestamps();
    }

    public function user() {
        return $this->belongsTo( User::class );
    }
    
     public function payment() {
        return $this->belongsTo( PaymentMethod::class, 'payment_method_id' );
    }
    
    public function delivery_destinations()
    {
        return $this->belongsTo(DeliveryDestination::class, 'delivery_destination_id');
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
    
    public function shipping_address()
    {
        return $this->belongsTo(ShippingAccount::class, 'address_id');
    }

    public function prebookings()
    {
        return $this->hasOne(Prebooking::class, 'order_id');
    }

//    public function orderReturnRequest() {
//        return $this->hasOne( OrderReturnRequest::class );
//    }
//
//    public function getShippingAddressAttribute() {
//        $shippingAddress = Address::findOrFail( $this->attributes['shipping_address_id'] );
//
//        return $shippingAddress;
//    }
//
//    public function getOrderStatusTitleAttribute() {
//        return $this->orderStatus->title;
//    }
//
//    public function getOrderDateAttribute( $value ) {
//        return Carbon::parse( $value )->format( 'Y/m/d' );
//    }
//
//    public function setOrderDateAttribute( $value ) {
//        $this->attributes['order_date'] = isValidTimestamp( $value ) ? $value : Carbon::createFromFormat( 'Y/m/d', $value )->toDateTimeString();
//    }
}
