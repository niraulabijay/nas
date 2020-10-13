<fieldset class="">
    <div class="row paymenting field">

        <div class="col-md-4">
            <div class="payment-method__container box-shadow">
                <h4 style="background: #c64732;font-family:roboto;padding: 15px;color:#fff;margin: 0;">
                    Payment method
                </h4>
                <div id="payment" class="checkout-payment">
                    <ul class=" payment_methods liststyle--none uk-margin-bottom">
                      
                          {{-- <li class="payment_method payment_method_cod">
                            <input id="payment_method_cod" type="radio" class="uk-radio input-radio"
                                   name="payment_method_id" value="5" checked="checked">

                            <label for="payment_method_cod">Cash on delivery </label>
                            <div class="payment_box payment_method_cod" style="display:none;">
                                <p>Pay with cash upon delivery.</p>
                            </div>
                        </li> --}}
                        <li class="payment_method payment_method_ebanks">
                            <!--<input id="payment_method_ebanks" type="radio" class="uk-radio input-radio"-->
                            <!--       name="payment_method" value="ebanks" >-->
                            <!--<label for="payment_method_ebanks">Direct bank transfer </label>-->
                            <div class="payment_box payment_method_banks">
                                @foreach($paymentMethod as $payment)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="payment_method_id" id="optionsRadios1"
                                                   value="{{$payment->id}}" {{ $loop->first ?  'checked' : '' }}>
                                            <figure class="payment-method__logo-box">
                                                <img src="{{ $payment->getImage()->mediumUrl }}" alt="">
                                            </figure>

                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </li>

                      
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div>
                <div class="confirm-order__container box-shadow">
                    <h4 style="background: #c64732; font-family:roboto;padding: 15px;color:#fff;margin: 0;">Confirm order</h4>
                    <div class="panel panel-default no-border-shadow">
                        <div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" style="font-family:roboto;">
                                        <thead>
                                        <tr class="warning">
                                            <td class="text-left">Product Name</td>
                                            <td class="text-right">Quantity</td>
                                            <td class="text-right">Unit Price</td>
                                            <td class="text-right">Total</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $tax = 0;
                                            $subtotal = 0;
                                        @endphp
                                        @if(Cart::instance('default')->count() > 0)
                                        @foreach(Cart::instance('default')->content() as $cartContent)
                                        @php
                                            $prebooking = App\Model\Product::findOrFail($cartContent->id)->prebooking;
                                        @endphp
                                            <tr>
                                                <td class="text-left"><a href="">{{ $cartContent->name }}</a>
                                                </td>
                                                <td class="text-right">{{ $cartContent->qty }} x</td>
                                                <td class="text-right">Rs.{{ $cartContent->price }}</td>
                                                @if($prebooking == 1)
                                                <td class="text-right">
                                                    Rs.{{ (($cartContent->price * $cartContent->qty) * 10) / 100 }}<br>
                                                    (10% of Rs. {{ $cartContent->price }})
                                                    <small>Prebooking</small>
                                                </td>
                                                
                                                @else
                                                <td class="text-right">
                                                    Rs.{{ ($cartContent->price * $cartContent->qty) }}</td>
                                                @endif
                                            </tr>
                                            @php
                                                if($prebooking == 1) {
                                                    $actualprice = (($cartContent->price * $cartContent->qty) * 10) / 100;
                                                    $subtotal += $actualprice;
                                                    $tax += 0;
                                                }
                                                else {
                                                    $actualprice = $cartContent->price * $cartContent->qty;
                                                    $subtotal += $actualprice;
                                                    $tax += ((($cartContent->price * $cartContent->qty) * App\Model\Product::findOrFail($cartContent->id)->tax) / 100);
                                                }
                                            @endphp
                                        @endforeach
                                        @endif
                                        @if(Cart::instance('prebooking')->count() > 0)
                                        @foreach(Cart::instance('prebooking')->content() as $cartContent)
                                        @php
                                            $prebooking = App\Model\Product::findOrFail($cartContent->id)->prebooking;
                                        @endphp
                                            <tr>
                                                <td class="text-left"><a href="">{{ $cartContent->name }}</a>
                                                </td>
                                                <td class="text-right">{{ $cartContent->qty }} x</td>
                                                <td class="text-right">Rs.{{ $cartContent->price }}</td>
                                                @if($prebooking == 1)
                                                <td class="text-right">
                                                    Rs.{{ (($cartContent->price * $cartContent->qty) * 10) / 100 }}<br>
                                                    (10% of Rs. {{ $cartContent->price }})
                                                    <small>Prebooking</small>
                                                </td>
                                                
                                                @else
                                                <td class="text-right">
                                                    Rs.{{ ($cartContent->price * $cartContent->qty) }}</td>
                                                @endif
                                            </tr>
                                            @php
                                                if($prebooking == 1) {
                                                    $actualprice = (($cartContent->price * $cartContent->qty) * 10) / 100;
                                                    $subtotal += $actualprice;
                                                    $tax += 0;
                                                }
                                                else {
                                                    $actualprice = $cartContent->price * $cartContent->qty;
                                                    $subtotal += $actualprice;
                                                    $tax += ((($cartContent->price * $cartContent->qty) * App\Model\Product::findOrFail($cartContent->id)->tax) / 100);
                                                }
                                            @endphp
                                        @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        @php
                                            // $subTotal = str_replace(',', '', Cart::instance('default')->subtotal());

                                            $grandTotal = $subtotal + $tax;

                                        @endphp
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Sub-Total:</strong></td>
                                            <td class="text-right">Rs.{{ $subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Tax:</strong></td>
                                            <td class="text-right">Rs. {{ number_format($tax, 2)}} </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Shipping:</strong></td>
                                            <td class="text-right" >Rs. <span id="ship_amnt">0</span> </td>
                                        </tr>
                                        @if(session()->exists('coupon'))
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Discount:</strong></td>
                                            <td class="text-right" >Rs. <span id="discount">{{ number_format(session()->get('coupon')['discount_value'], 2) }}</span> </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                            <td class="text-right" >
                                                Rs.<span id="ship_amnt_total">{{ session()->exists('coupon') ? number_format($grandTotal - session()->get('coupon')['discount_value'], 2) : number_format($grandTotal, 2) }}</span></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <p class="terms-and-conditions">
                                    <label class="form__label-for-checkbox">

                                        <input type="checkbox" class="uk-checkbox input-checkbox"
                                               name="terms"
                                               id="terms" onchange="document.getElementById('confirmation_term').disabled = !this.checked">
                                        <span>I’ve read and accept the <a href="" target="_blank"
                                                                          class="terms-and-conditions-link">terms &amp; conditions</a></span>
                                        <span class="required">*</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn box-shadow" id="confirmation_term" disabled style="width:25%;background:#ffa500;color:#fff;border:none;border-radius:2px;">Confirm Order</button>
                </div>
            </div>
        </div>
    </div>
</fieldset>