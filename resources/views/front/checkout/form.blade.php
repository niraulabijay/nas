<fieldset>
    <div class="row">
    <div class="col-md-7 col-sm-12 deliver__address" style="margin-bottom:0px; background:#fff;border-radius:2px;">
        <h2><span class="glyphicon glyphicon-home"></span> Delivery Address</h2>
        <div class="row">
            <div class="col-sm-6 col-12 form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                <label for="fname">First Name</label>
                <input type="text" name="first_name" id="fname" class="form-control" placeholder="First name" value="{{ isset($shipping->first_name)?$shipping->first_name: old('first_name') }}">
                @if ($errors->has('first_name'))
                    <span class="help-block">
                        {{ $errors->first('first_name') }}
                    </span>
                @endif
            </div>
            <div class="col-sm-6 col-12">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="last_name" class="form-control" placeholder="Last name" value="{{ isset($shipping->last_name)?$shipping->last_name: old('last_name') }}">
                @if ($errors->has('last_name'))
                    <span class="help-block">
                        {{ $errors->first('last_name') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-12">
                <label for="inputEmail">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail" value="{{ isset($shipping->email)?$shipping->email: old('email') }}" placeholder="Email">
                @if ($errors->has('email'))
                    <span class="help-block">
                        {{ $errors->first('email') }}
                    </span>
                @endif

            </div>
            <div class="col-sm-6 col-12">
                <label for="country">Country</label>
                <select class="uk-select" id="country" name="country">
                    <option value="Nepal">Nepal</option>

                </select>
                @if ($errors->has('country'))
                    <span class="help-block">
                      {{ $errors->first('country') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-12">
                <label for="mobile">Mobile *</label>
                <input type="text" name="mobile" class="form-control" id="mobilenumber" value="{{ isset($shipping->mobile)?$shipping->mobile:old('mobile') }}" placeholder="Mobile">
                @if ($errors->has('mobile'))
                    <span class="help-block">
                        {{ $errors->first('mobile') }}
                    </span>
                @endif

            </div>
            <div class="col-sm-6 col-12">
                <label for="phone">Mobile 2</label>
                <input type="text" name="phone" class="form-control" id="phone" value="{{ isset($shipping->phone)?$shipping->phone: old('phone')}}" placeholder="Mobile 2">
                @if ($errors->has('phone'))
                    <span class="help-block">
                        {{ $errors->first('phone') }}
                    </span>
                @endif

            </div>
        </div>
        <div class="row">


            <div class="col-sm-6 col-12">
                <label for="inputAddress">Province</label>
                <select class="uk-select" id="zone" name="zone">
                    <option value="0" disabled="" selected>Select Province</option>
                    @foreach(\App\DeliveryCharge::where('parent_id',0)->get() as $zones)
                    <option value="{{$zones->id}}">{{$zones->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('zone'))
                    <span class="help-block">
                        {{ $errors->first('zone') }}
                    </span>
                @endif
            </div>

            <div class="col-sm-6 col-12">
                <label for="inputdistrict">District</label>
                <select class="uk-select" id="district" name="district" disabled>
                    <option value="0" disabled="" selected>Select Option</option>

                </select>
                @if ($errors->has('district'))
                    <span class="help-block">
                        {{ $errors->first('district') }}
                    </span>

                @endif
            </div>





</div>



            <div class="row">
                <div class="col-sm-12 col-12">
                    <label for="area">Area</label>
                    <select class="uk-select" id="area" name="area" disabled>
                        <option value="0">Select Option</option>

                    </select>
                        @if ($errors->has('area'))
                            <span class="help-block">
                        {{ $errors->first('area') }}
                    </span>

                    @endif
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-sm-12 col-12">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" id="address" value="{{old('address')}}">
                    
                        @if ($errors->has('address'))
                            <span class="help-block">
                        {{ $errors->first('address') }}
                    </span>

                    @endif
                </div>
            </div>



        <div class="row">
            <div class="col-12">
                @role(['admin','logistics','customer_care','digital_marketing'])
                <button class="uk-button check--user" id="chckbtnusercus">Check This User</button>
                @endrole
                <button type="button" class="uk-button next submit saveaddress" id="saveaddcusrahu" >Save this address</button>
            </div>
        </div>
    </div>
    <div class="col-md-5 col-sm-12" id="mblrespreview">
        <div class="card ">
            <div class="card-header" style="margin-bottom: 10px;">
                Review Order
                <div class="float-right">
                    <small><a class="afix-1" href="{{ route('cart') }}">Edit Cart</a></small>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-block">
                <div class=" group">
                    @php
                        $tax = 0;
                        $subtotal = 0;
                    @endphp
                    @if(Cart::instance('default')->count() > 0)
                    @foreach(Cart::instance('default')->content() as $cartContent)
                    @php
                        $prebooking = App\Model\Product::findOrFail($cartContent->id)->prebooking;
                    @endphp
                    <div class="row">
                        <div class="col-sm-3 col-3">
                            <img class="img-fluid"
                                 src="{{ asset(getProductImage($cartContent->id, 'small')) }}" alt="{{ $cartContent->name }}" />
                        </div>
                        <div class="col-sm-6 col-6">
                            <div class="col-12">{{ $cartContent->name }}</div>
                            <div class="col-12">
                                <small>Quantity:<span>{{ $cartContent->qty }}</span></small>
                            </div>
                        </div>
                        <div class="col-sm-3 col-3 text-right">
                            @if($prebooking == 1)
                            <h6><span>Rs.</span>{{ (($cartContent->price * $cartContent->qty) * 10) / 100 }}</h6>
                            (10% of Rs. {{ $cartContent->price }})
                            <small>Prebooking</small>
                            @else
                            <h6><span>Rs.</span>{{ $cartContent->price }}</h6>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
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
                    <div class="row">
                        <div class="col-sm-3 col-3">
                            <img class="img-fluid"
                                 src="{{ asset(getProductImage($cartContent->id, 'small')) }}" alt="{{ $cartContent->name }}" />
                        </div>
                        <div class="col-sm-6 col-6">
                            <div class="col-12">{{ $cartContent->name }}</div>
                            <div class="col-12">
                                <small>Quantity:<span>{{ $cartContent->qty }}</span></small>
                            </div>
                        </div>
                        <div class="col-sm-3 col-3 text-right">
                            @if($prebooking == 1)
                            <h6><span>Rs.</span>{{ (($cartContent->price * $cartContent->qty) * 10) / 100 }}</h6>
                            (10% of Rs. {{ $cartContent->price }})
                            <small>Prebooking</small>
                            @else
                            <h6><span>Rs.</span>{{ $cartContent->price }}</h6>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
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
                </div>
                @php
                    $grandTotal = $subtotal + $tax;
                @endphp

                <div class="row">
                    <div class="col-12">
                        <strong>Subtotal</strong>
                        <div class="float-right"><span>Rs.</span><span>{{ $subtotal }}</span></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-12">
                        <strong>Tax</strong>
                        <div class="float-right"><span>Rs.</span><span>{{ number_format($tax,2)  }}</span></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-12">
                        <small style="letter-spacing: .5px;
    font-weight: 500; color:#000" >Shipping</small>
                        <div class="float-right"><span class="item-price">Rs. <span id="shipping_charge"> 0.00</span> </span></div>
                        <div class="clearfix"></div>
                    </div>
                    @if(session()->exists('coupon'))
                    <div class="col-12">
                        <smallstyle="letter-spacing: .5px;font-weight: 500; color:#000">Discount</small>
                        <div class="float-right"><span class="item-price">Rs. <span id="discount"> {{ number_format(session()->get('coupon')['discount_value'], 2) }}</span> </span></div>
                        <div class="clearfix"></div>
                    </div>
                    @endif
                </div>
                <hr>

                <div class="row" style="padding: 0 0 10px">
                    <div class="col-12">
                        <strong>Order Total</strong>
                        <div class="float-right"><span>Rs.</span><span id="grand_total_value">{{ session()->exists('coupon') ? number_format($grandTotal - session()->get('coupon')['discount_value'], 2) : number_format($grandTotal, 2) }}</span></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="background: #fff;border-radius: 4px;box-shadow: 0px 1px 8px 0px #cbcbcb;
    margin-top: 10px;">
            <div class="col-12">
                <label for="order_note">Order Note</label>
                <textarea name="order_note" class="form-control" id="order_note" rows="3" placeholder="Additional things you want to say...">{{old('address')}}</textarea>
                @if ($errors->has('order_note'))
                    <span class="help-block">
                        {{ $errors->first('order_note') }}
                    </span>
                @endif

            </div>
            <div class="col-12">
                <label for="order_date">Delivery Day</label>
                <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Within</span>
                          </div>
                           <input type="number" value="{{old('order_date')}}"class="form-control reportrange" name="order_date" placeholder="2" min="1">
                          <div class="input-group-append">
                            <span class="input-group-text">day</span>
                          </div>
                        </div>
               
                
                @if ($errors->has('order_date'))
                    <span class="help-block">
                        {{ $errors->first('order_date') }}
                    </span>
                @endif
                

            </div>
            
        </div>
    </div>
</div>
</fieldset>

