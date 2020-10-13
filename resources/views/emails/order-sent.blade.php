@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
     <img src="{{ url('storage').'/'.getConfiguration('site_logo')}}" alt="" width="150px">        @endcomponent
    @endslot


# Thank You For Your Purchase
** Hi &nbsp;{{$content['name']}}, We are getting Your Order Ready to be Shipped. We will Notify You When it has been Sent .**
@component('mail::button', ['url' => route('my-account.order-details', $content['order']->id) ,'color' => 'red'])
   View Your Order
@endcomponent
<div style="display: inline-block"> Or <a href="{{url('/')}}">Visit Our Store</a></div>

@component('mail::subcopy')

 # Order Summary
<table class="table table-striped table-condensed" border="0">
<thead>
<tr>
    <th><h4>Product </h4> </th>
    <th><h4>Price</h4> </th>
    <th><h4>Quantity</h4> </th>
    <th><h4>Total</h4> </th>
</tr>
</thead>
<tbody>
<?php
    $discountAmount_ = 0;
    $productSubTotal_ = 0;
    $taxAmount_ = 0;
?>
@foreach($content['order']->orderProduct as $product)
@php

    $discount = $product->discount;
    $tax = $product->tax;
    $actualPrice = $product->price * $product->qty;
    $taxAmount = (($actualPrice * $tax) / 100);
    $taxAmount_ += $taxAmount;
    $actualPrice_ = $actualPrice + $taxAmount;
    $discountAmount = $discount;
    $discountAmount_ += $discountAmount;
    $productSubTotal = $actualPrice_ - ( $discountAmount );
    if(isset($content['order']->prebookings)) {
        $productSubTotal_ = $product->price - $content['order']->prebookings->price;
    }
    else {
        $productSubTotal_ += $actualPrice;
    }

@endphp
<tr>
    <td>
    <h4>{{ strip_tags($product->products->name  ) }}</h4> 
    @if($product->size != null)
        Size: {{ $product->size }}
    @endif
    @if($product->products->color != null)
        Color: {{ $product->products->color }}
    @endif
    </td>
    <td><h4> Rs. {{$product->price }}</h4></td>
    <td><h4>{{$product->qty}}</h4> </td>
    <td><h4> Rs. {{$product->price * $product->qty}}</h4></td>

</tr>
@endforeach
@php
    $grandTotal = $productSubTotal_ + $taxAmount_ - $discountAmount_ + $content['ship_amount'];
@endphp
<tr>
    <td colspan="3"><h4>Subtotal @if(isset($content['order']->prebookings)) (90% of Preorder) @endif</h4></td>
    <td><h4>Rs.{{ $productSubTotal_ }}</h4></td>
</tr>
<tr>
    <td colspan="3"><h4>Tax</h4></td>
    <td><h4>Rs.{{ $taxAmount_ }}</h4></td>
</tr>
<tr>
    <td colspan="3"><h4>Discount</h4></td>
    <td><h4>Rs.{{ $discountAmount_ }}</h4></td>
</tr>
<tr>
    <td colspan="3"><h4>Shipping</h4></td>
    <td>
        @if( $content['ship_amount'])
            <h4>Rs. {{ $content['ship_amount'] }} </h4>
        @else
            <h4>-</h4>
        @endif
    </td>
</tr>
<tr>
    <td colspan="3"> <h4>Grandtotal</h4></td>
    <td>
        <h4>Rs. {{ $grandTotal }}</h4>
    </td>
</tr>
</tbody>
</table>
@endcomponent

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent