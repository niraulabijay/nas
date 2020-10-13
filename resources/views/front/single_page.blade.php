@extends('layouts.app')
@section('title')
    {{ $product->name .'-'}} Nepal All Shop
@stop

@if(isset( $product->seos->first()->meta_description))
@section('site_description')
    {{ $product->seos->first()->meta_description }}
@stop

@endif
@section('site_title')
    {{ $product->name }}
@stop

@section('extra_styles')


@endsection
@section('content')
<style>
    img#xzoom-fancy {
    box-shadow: none !important;
    border: 1px solid #eee;
}
#commentsinglepage{
    border: none;
    color: #fff;
    background-color: #c64732;
    border-color: #17a2b8;
    border-radius: 0px;
    
}
.commenttextarea{
    border-radius:0px !important;
}
#commenttext{
    font-size: 15px;
    text-transform: capitalize;
    margin-bottom: 10px;
}
.uk-breadcrumb>*>* {
    display: inline-block;
    font-size: 15px !important;
    color: #003470 !important;
    font-weight: 500 !important;
}
</style>
    <section id="single-page" style="background:#f7f7f7;">
        <div class="container">
<div class=" d-none d-md-block">
                        <section class="breadcrumbs ">
                            <ul class="uk-breadcrumb" style="    margin-top: -15px;
    margin-bottom: 10px;">
                                <li><a href="{{ route('home.index') }}">Home</a></li>
                                @foreach($product->categories as $category)
                                @if($category->parent_id != 0)
                                    @php
                                        $parent = App\Model\Category::where('id', $category->parent_id)->first();
                                    @endphp
                                    @if($parent->parent_id != 0)
                                        @php
                                            $cat = App\Model\Category::where('id', $parent->parent_id)->first();
                                        @endphp
                                        @if($cat->parent_id != 0)
                                            @php
                                                $sub = App\Model\Category::where('id', $cat->parent_id)->first();
                                            @endphp
                                            <li><a href="{{ route('category', $sub->slug) }}">{{ $sub->name }}</a></li>
                                        @endif
                                        <li><a href="{{ route('category', $cat->slug) }}">{{ $cat->name }}</a></li>
                                    @endif
                                    <li><a href="{{ route('category', $parent->slug) }}">{{ $parent->name }}</a></li>
                                @endif
                                <li><a href="{{ route('category', $category->slug) }}">{{ $category->name }}</a></li>
                                @endforeach
                                <li class="last"><span style="font-size: 14px; color: #c64732 !important; opacity:0.9;font-weight: 600;">{{ $product->name }}</span></li>
                            </ul>
                        </section>
                    </div>
            <div class="row" style="    background: #fff;
    padding: 10px;">
                <div class="d-sm-block d-md-none mb">
                    <section class="breadcrumbs ">
                        <ul class="uk-breadcrumb">
                            <li><a href="{{ route('home.index') }}">Home</a></li>
                            <li class="last"><span>{{ $product->name }}</span></li>
                        </ul>
                    </section>
                </div>
                <div class=" col-lg-5 col-md-6">
                    <div class="xzoom-container" style="z-index: 980; box-shadow:none;" uk-sticky="offset: 100; bottom:true " >
                        <div class="default__zoom">
                            <div class="image__zoom">
                                <img class="xzoom4 block__pic" id="xzoom-fancy" src="{{ $product->getImageAttribute()->mediumUrl }}" xoriginal="{{ $product->getImageAttribute()->url }}" />
                            </div>
                            @if($product->prebooking == 0)
                            @if($product->stock_quantity != 0 && $product->stock != 0)
                            <div class="buttons__for mb desktop">
                                <div class="button__addtocart">
                                    <a class="btn btn-default button__addtocart__link addtocart" data-product="{{ $product->id }}" href="#">
                                        <!--<img src="http://i68.tinypic.com/2rm38rr.png" style=" width: 24px; margin-right: 5px; "-->
                                        <!--    alt="">-->
                                        <span>Add to cart</span></a>
                                </div>
                                <div class="button__buynow">
                                    <a class="btn btn-default button__buynow__link buynow" data-product="{{ $product->id }}" href="#">
                                        <!--<img src="http://i65.tinypic.com/2rw7xpc.png" style="width: 20px;margin-right: 5px;"-->
                                        <!--    alt="">-->
                                        <span>Buy Now</span></a>
                                </div>
                            </div>
                            @endif
                            @else
                            <div class="buttons__for mb desktop">
                                <div class="button__addtocart">
                                    <a class="btn btn-default button__addtocart__link buynow" data-product="{{ $product->id }}" href="#">
                                        <img src="http://i68.tinypic.com/2rm38rr.png" style=" width: 24px; margin-right: 5px; "
                                            alt="">
                                        <span>Prebooking</span></a>
                                </div>
                            </div>
                            @endif
                            <div class="buttons__for mb mobile">
                                <div class="button__addtocart">
                                    <a class="btn btn-default button__addtocart__link addtocart" data-product="{{ $product->id }}" href="#">
                                        <!--<img src="http://i68.tinypic.com/2rm38rr.png" style=" width: 24px; margin-right: 5px; "-->
                                        <!--    alt="">-->
                                        <span>Add to cart</span></a>
                                </div>
                                <div class="button__buynow">
                                    <a class="btn btn-default button__buynow__link buynow" data-product="{{ $product->id }}" href="#">
                                        <!--<img src="http://i65.tinypic.com/2rw7xpc.png" style="width: 20px;margin-right: 5px;"-->
                                        <!--    alt="">-->
                                        <span>Buy Now</span></a>
                                </div>
                            </div>
                        </div>

                        <div class="xzoom-thumbs">
                            @foreach($product->getProductGallery() as $image)
                              <a href="{{ $image->url }}">
                                <img class="xzoom-gallery4" @if($loop->first) src="{{ $image->smallUrl }}" xpreview="{{ $image->mediumUrl }}" @else src="{{ $image->mediumUrl }}" @endif>
                              </a>
                           @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    
                    <div class="summary entry-summary product-details">
                        <h1 class="product_title entry-title">
                            <a href="">{{ $product->name }}</a>
                        </h1>
                        <div class="shear-brand">

                            <div class="product-rating">
                                <div class="d-flex">
                                    <div class="star-rating">
                                        <span style="width:100%">
                                            @for( $i=0;$i<$product->getAverageRating();$i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </span>
                                    </div>
                                    <a href="#reviews" class="review-link">(<span class="count">{{$product->reviews->where('status',1)->count()}}</span> customer
                                        review)
                                    </a>
                                </div>

                                <div class="button__wish">
                                    <a href="" uk-icon="heart" class="addtowishlist" data-product="{{ $product->id }}" uk-tooltip="Add To Wishlist"></a>
                                </div>
                            </div>
                            <div class="brandwrap">
                                <div class="row">
                                 
                            @if($product->approved == 1)
                            <div class="product-approved-container mt-2">
                                 <ul style="display:inline-flex">
                                            <li>Brand:&ensp;</li>
                                            <li><a href="#">Non-Brand</a></li>
                                        </ul>
                                     <img src="{{ asset('img/seller/assusred.png') }}" alt="" style="max-width: 15%">
                            </div>
                            @endif
                            </div>
                            </div>
                            <div class="product-price-container">
                                <span class="d-block" style="opacity:.5;">Special price</span>
                                <p class="price">
                                    @if($product->sale_price > 5)
                                                             <span class="Price-amount amount">
                                                                <span class="Price-currencySymbol">Rs</span>{{ number_format($product->sale_price) }}
                                                            </span><span class="Price-amount discount">
                                                            <span class="Price-currencySymbol">Rs</span>{{ number_format($product->product_price) }}
                                                        </span>
                                                        @else
                                                        
                                                        <span class="Price-amount amount">
                                                            <span class="Price-currencySymbol">Rs</span>{{ number_format($product->product_price) }}
                                                        </span>
                                                        @endif   
                                    
                                </p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @if($product->sku)
                         <div class="delivery_address d-flex align-items-center py-2">
                               <i class="fas fa-tag" id="singlepgerahul"></i>  <h5 style=" width: 35px;"> SKU</h5>
                                <div class="delivery_location">
                                    <p>{{ $product->sku }}</p>
                                </div>
                            </div>
                        @endif   
                          <div class="seller_name d-flex align-items-center py-2 ">
                            <i class="fas fa-tag" id="singlepgerahul"></i>  
                            <h5> Seller</h5>
                            @if(isset($shop_name))
                            <p class="badge" id="vendorname"> <a href="{{ route('vendor.product',$shop_slug ) }}">{{ isset($shop_name) ? $shop_name : $product->users->first_name }}</a></p>
                            @endif

                        </div>
                        @if($product->stock_quantity == 0 && $product->stock == 0 && $product->prebooking == 0)
                            <div class="notify-users">
                                <div>
                                    <h2 class="text-success">Sold Out</h2>
                                    <h4>This item is currently out of stock</h4>
                                    <form action="{{ route('notify.stock') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" style="display: inline-block;">
                                            <input type="email" name="email" class="form-control" placeholder="Enter email to get notified" required>
                                            @if($errors->has('email'))
                                                <span class="help-block">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn btn-danger">Notify me</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            @if($product->features->isNotEmpty())
                            <div class="product-details__short-description uk-margin-top mb">
                                <ul>
                                    @foreach($product->features->slice(0,5) as $feature)
                                    <li><i class="fas fa-tag"></i>{{ $feature->feature }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="delivery_address d-flex align-items-center py-2">
                                <i class="fas fa-tag" id="singlepgerahul"></i> <h5> Delivery</h5>
                                <div class="delivery_location">
                                    {{-- <form action="" class="d-flex flex-wrap">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <input type="text">
                                        <button type="submit" style="color:white; background:#f25548; padding: 5px; border:none; margin:5px 0; cursor: pointer;">
                                            find now
                                        </button>
                                    </form> --}}
                                    <p>Usually delivered in {{ $product->from }}-{{ $product->to }} days</p>
                                </div>
                            </div>
                        @endif
                        @if(count($products) > 1)
                        <div class="color_option d-flex align-items-center py-2  " id="colorrahul">
                            <h5> Colors</h5>
                            <div class="custom-radios_for_colors">
                                @foreach( $products as $relation)
                                    <div>
                                        <input type="radio" id="color-{{$loop->index}}" name="colour" value="" >
                                        <label class="grey" for="color-{{$loop->index}}" @if($product->id == $relation->id) style="border: 2px solid dodgerblue;" @endif>
                                            <span>
                                                <span class="color_option_list"><a href="{{ route('product.show', $relation->slug) }}"><img src="{{ $relation->getImageAttribute()->smallUrl }}"
                                                            alt=""></a></span>
                                                {{-- <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg" alt="Checked Icon" /> --}}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if (!empty($sizes))
                        <div class="size_option d-flex align-items-center py-2 ">
                            <h5> Size</h5>
                            <div class="custom-radios">
                                @foreach(array_unique($sizes) as $size)
                                    <div>
                                        <input type="radio" id="size-{{$loop->index}}" name="size" value="{{ $size }}" >
                                        <label class="grey" for="size-{{$loop->index}}">
                                            <span @if(strtolower($size) == "free" || strtolower($size) == "free size") style="width:80px;" @endif >
                                                <div class="text">{{ $size }}</div>
                                                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg"
                                                    alt="Checked Icon" />
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            {{-- <select id="select_size" class="uk-select">
                                <option disabled="">select Size</option>
                                @foreach(array_unique($sizes) as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select> --}}
                        </div>
                        @endif
                        
                            @if($product->stock_quantity > 0)
                         <div class="product-quantity quantity d-flex align-items-center py-2">
                            <h5 style="margin-right:15px; margin-bottom:-10px;">Quantity </h5>
                            <div>
                                <input type="number" class="form-control" id="quantity" value="1" min="1" max="{{$product->stock_quantity}}" size="4">
                            </div>
                        </div>
                        @endif
                      

                    <!--</div>-->

                    <div id="product__detail__description" style=" background: #fcfcfc;">
                        <div class="product__detail__description  p-4 mb mt-3" style="margin-bottom:10px !important;    border: 1px solid #eee;">
                            <div class="product__name heading">
                                <h3>
                                    Product detail of {{ $product->name }}
                                </h3>
                            </div>
                            

                            <div class="product_information_list mb">
                                {!! $product->long_description !!}
                            </div>

                            @if($product->features->isNotEmpty())
                            <div class="product_information_list mb">
                                <ul>
                                    @foreach($product->features as $feature)
                                    <li class="">{{ $feature->feature }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if($product->specifications->isNotEmpty())
                            <div class="product-desc-list">
                                @foreach($product->specifications as $specification)
                                <div class="details-desc">
                                    <span class="details-desc-title">{{ $specification->title }}</span>
                                    <span class="desc-list-item">{{ $specification->description }}</span>
                                    <span class="clearfix"></span>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <!-- product review -->
                        <div id="product__review " style="border: 1px solid #eee;">
                            <div class="mb p-4" style=" background: white;">
                                <div class="product__review__name heading">
                                    <h3>
                                        Reviews of {{ $product->name }}
                                    </h3>
                                </div>
                                
                                <form action="{{ route('review.post') }}" method="post" class="review-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <div class="" style="padding: 10px 0px;">
                                        <span class="review--heading">Customer review</span>
                                        <fieldset class="rating">
                                            <input type="radio" id="star5" name="stars" value="5" />
                                            <label class="full" for="star5" title="Awesome - 5 stars"></label>
                                            <input type="radio" id="star4" name="stars" value="4" />
                                            <label class="full" for="star4" title="Pretty good - 4 stars"></label>
                                            <input type="radio" id="star3" name="stars" value="3" checked />
                                            <label class="full" for="star3" title="Meh - 3 stars"></label>
                                            <input type="radio" id="star2" name="stars" value="2" />
                                            <label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                                            <input type="radio" id="star1" name="stars" value="1" />
                                            <label class="full" for="star1" title="Sucks big time - 1 star"></label>
                                        </fieldset>
                                        <div class="clearfix"></div>
                                    </div>
                                    <p class="comment" id="commenttext">write something</p>
                                    <textarea type="text" name="review" class="form-control commenttextarea" id="comment" placeholder="write something"
                                        rows="3" cols="100">
                                    </textarea>
                                    <button class="btn btn-info " type="submit" id="commentsinglepage"> comment</button>
                                    <div class="clearfix"></div>
                                </form>
                                <div class="clearfix"></div>

                                @if( $product->reviews->where('status', 1)->isNotEmpty())
                                    @php
                                        if($product->reviews->isNotEmpty())
                                        {
                                        $total = $product->reviews->count();
                                        $five = ($product->reviews->where('stars', 5)->count() / $total) * 100;
                                        $four = ($product->reviews->where('stars', 4)->count() / $total) * 100;
                                        $three = ($product->reviews->where('stars', 3)->count() / $total) * 100;
                                        $two = ($product->reviews->where('stars', 2)->count() / $total) * 100;
                                        $one = ($product->reviews->where('stars', 1)->count() / $total) * 100;
                                        $average = (($product->reviews->where('stars', 5)->count() * 5) +
                                                    ($product->reviews->where('stars', 4)->count() * 4) +
                                                    ($product->reviews->where('stars', 3)->count() * 3) +
                                                    ($product->reviews->where('stars', 2)->count() * 2) +
                                                    ($product->reviews->where('stars', 1)->count() * 1)) / $total;
                                    }
                                    @endphp
                                    <p class="review-user">{{ number_format($average, 1) }} average based on {{ $product->reviews->count() }} reviews.</p>
                                    <hr style="border:3px solid #f1f1f1; width:70%">
                                    <div class="row review-rating">
                                        <div class="side">
                                            <div>5 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                                <div class="bar-5" style="width: {{ number_format($five, 2) }}%"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div>{{ $product->reviews->where('stars', 5)->count() }}</div>
                                        </div>
                                        <div class="side">
                                            <div>4 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                                <div class="bar-4" style="width: {{ number_format($four, 2) }}%"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div>{{ $product->reviews->where('stars', 4)->count() }}</div>
                                        </div>
                                        <div class="side">
                                            <div>3 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                                <div class="bar-3" style="width: {{ number_format($three, 2) }}%"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div>{{ $product->reviews->where('stars', 3)->count() }}</div>
                                        </div>
                                        <div class="side">
                                            <div>2 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                                <div class="bar-2" style="width: {{ number_format($two, 2) }}%"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div>{{ $product->reviews->where('stars', 2)->count() }}</div>
                                        </div>
                                        <div class="side">
                                            <div>1 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                                <div class="bar-1" style="width: {{ number_format($one, 2) }}%"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div>{{ $product->reviews->where('stars', 1)->count() }}</div>
                                        </div>
                                    </div>
                                    <div class="review-container">
                                        <h3 class="review-title">Reviews</h3>
                                        @foreach($product->reviews->where('status', 1) as $review)
                                        <article class="reviews">
                                            <figure class="user-image" style="width: 45px;">
                                                <img src="{{ $review->users->getImage() ? $review->users->getImage()->smallUrl : asset('/front/img/default-product.jpg') }}"
                                                    alt="{{ $review->users->first_name . ' ' . $review->users->last_name }}" title="{{ $review->users->first_name . ' ' . $review->users->last_name }}">
                                            </figure>
                                            <div class="review-right">
                                                <span class="username"> {{ $review->users->first_name . ' ' . $review->users->last_name }}</span>&nbsp;<span class="published">{{ $review->created_at->diffForHumans() }}</span>&nbsp;&nbsp;<span>@for($i=0;$i<$review->stars;$i++)
                                                                    <span uk-icon="icon: star"></span>
                                                                @endfor stars</span>
                                                <p>{{$review->review}}</p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </article>
                                        @endforeach

                                        @if($product->reviews->where('status', 1)->count() > 3)
                                        <button class="btn show-more center"> show more</button>
                                        @endif
                                        <div class="clearfix"></div>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class=" category mb" style="margin-bottom: 10px !important;">
        <div class="container">
            <div class=" box-shadow">
                <div class="category-title border_bottom">
                    <div class="category--title float-left">
                        <h5>Similar Products</h5>
                    </div>
                    <a href="{{ route('category', ['slug' => $product->categories->first()->slug]) }}" class="float-right view-more">view more</a>
                    <div class="clearfix"></div>
                </div>
                <div class="product-category white-product">

                    <div class="owl-carousel categories">
                        @foreach($relatedProducts as $product)
                        <article class="product instock sale purchasable">
                            <div class="product-wrap">
                                <div class="product-top">
                                    @if($product->product_price>5)
                                        @php
                                            $discount = $product->product_price-$product->sale_price;
                                            $discount_percentage = $discount/$product->product_price*100;
                                        @endphp
                                        <span class="product-label discount">-{{ number_format($discount_percentage)}}%</span>
                                    @endif
                                    <figure>
                                        <a href="{{ route('product.show', ['slug' => $product->slug]) }}">
                                            <div class="product-image">
                                                <img width="320" height="320"
                                                     src="{{ $product->getImageAttribute()->mediumUrl }}"
                                                     class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}">
                                            </div>
                                        </a>
                                    </figure>
                                </div>
                                <div class="product-description">
                                    <div class="product-meta">
                                        <div class="title-wrap">
                                            <p class="product-title">
                                                <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="line-clamp1" >{{ $product->name }}</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="product-meta-container">
                                        <div class="product-price-container">
                                            <span class="price">
                                                <span class="Price-amount discount">
                                                    <span class="Price-currencySymbol">Rs</span>{{ number_format($product->product_price) }}
                                                </span>
                                                <span class="Price-amount amount">
                                                        <span class="Price-currencySymbol">Rs</span>{{ number_format($product->sale_price) }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    
  <section class=" category mb" style="margin-bottom: 10px !important;">
        <div class="container">
            <div class=" box-shadow">
                <div class="category-title border_bottom">
                    <div class="category--title float-left">
                        <h5>Recommended Product </h5> Product may you like</h5>
                    </div>
                    <a href="{{ route('category', ['slug' => $product->categories->first()->slug]) }}" class="float-right view-more">view more</a>
                    <div class="clearfix"></div>
                </div>
                <div class="product-category white-product">

                    <div class="owl-carousel categories">
                        @foreach($lastestProducts as $product)
                        <article class="product instock sale purchasable">
                            <div class="product-wrap">
                                <div class="product-top">
                                    @if($product->product_price>5)
                                        @php
                                            $discount = $product->product_price-$product->sale_price;
                                            $discount_percentage = $discount/$product->product_price*100;
                                        @endphp
                                        <span class="product-label discount">-{{ number_format($discount_percentage)}}%</span>
                                    @endif
                                    <figure>
                                        <a href="{{ route('product.show', ['slug' => $product->slug]) }}">
                                            <div class="product-image">
                                                <img width="320" height="320"
                                                     src="{{ $product->getImageAttribute()->mediumUrl }}"
                                                     class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}">
                                            </div>
                                        </a>
                                    </figure>
                                </div>
                                <div class="product-description">
                                    <div class="product-meta">
                                        <div class="title-wrap">
                                            <p class="product-title">
                                                <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="line-clamp1" >{{ $product->name }}</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="product-meta-container">
                                        <div class="product-price-container">
                                            <span class="price">
                                                <span class="Price-amount discount">
                                                    <span class="Price-currencySymbol">Rs</span>{{ number_format($product->product_price) }}
                                                </span>
                                                <span class="Price-amount amount">
                                                        <span class="Price-currencySymbol">Rs</span>{{ number_format($product->sale_price) }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="quickview-modal" class="product-description" uk-modal></div>

@endsection
@section('extra_scripts')


    <script>

        $(document).on("click", ".addtowishlist", function (e) {
            e.preventDefault();
            var $this = $(this);
            var product = $this.attr('data-product');

            if (product) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('wishlist.store')  }}",
                    data: {
                        product: product
                    },
                    beforeSend: function (data) {
                        $this.prop('disabled', true);
                    },
                    success: function (data) {
                        if (data.status) {
                            $('.alert-message.alert-danger').fadeOut();

                            var message = '<div><span><strong><i class="fa fa-thumbs-o-up"></i>Success!</strong> ';
                            message += data.message;
                            message += '</span><a href="{{ route('home') }}" class="btn btn-xs btn-primary pull-right">View wishlist</a></div>';

                            $('.alert-message.alert-success').html(message).fadeIn().delay(3000).fadeOut('slow');

                            sweetAlert('success', 'Success', data.message + '<a href="{{ route('home') }}"> View Wishlist</a>');
                        }

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var err;
                        if (xhr.status === 401) {
                            err = eval("(" + xhr.responseText + ")");
                            sweetAlert('error', 'Oops...', err.message + '<a href="{{ route('login') }}"> Login</a>');
                            return false;
                        }

                        sweetAlert('error', 'Oops...', 'Something went wrong!');
                    },
                    complete: function () {
                        $this.prop('disabled', false);
                        //$("html, body").animate({scrollTop: 0}, "slow");
                    }
                });
            }

        });

        function UpdateMiniCart() {
            $.ajax({
                type: "GET",
                url: "{{ route('cart.mini')  }}",
                beforeSend: function (data) {
                    //
                },
                success: function (data) {
                    $('#update-cart').html(data);
                    $('#update-minicart').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //
                },
                complete: function () {
                    //
                }
            });
        }

        function sweetAlert(type, title, message) {
            swal({
                title: title,
                html: message,
                type: type,
                confirmButtonColor: '#ee3d43',
                timer: 3000
            }).catch(swal.noop);
        }

        // Add product to cart
    $(document).on("click", ".addtocart", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.attr('data-product');
        var quantity = $('#quantity').val();
        quantity = quantity ? quantity : 1;
        // var select = document.getElementById("select_size");
        // if (select) {
        //     var size = select.options[select.selectedIndex].value;
        // }
        if (document.querySelector('input[name="size"]:checked')) {
            var size = document.querySelector('input[name="size"]:checked').value;
        }
        // if (document.querySelector('input[name="colour"]:checked')) {
        //     var colour = document.querySelector('input[name="colour"]:checked').value;
        // }
        // size = size ? size : 1;

        if (product) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('cart.store')  }}",
                data: {
                    product: product,
                    quantity: quantity,
                    size: size
                    // colour: colour
                },
                beforeSend: function (data) {
                    $this.button('loading');
                },
                success: function (data) {
                    if (data.status) {
                        $('.alert-message.alert-danger').fadeOut();

                        var message = '<div><span><strong><i class="fa fa-thumbs-o-up"></i>Success!</strong> ';
                        message += data.message;
                        message += '</span><a href="{{ route('cart') }}" class="btn btn-xs btn-primary pull-right">View cart</a></div>';

                        $('.alert-message.alert-success').html(message).fadeIn().delay(3000).fadeOut('slow');

                        sweetAlert('success', 'Success', data.message + '<a href="{{ route('cart') }}"> View Cart</a>');
                    }

                    UpdateMiniCart();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var err;
                    if (xhr.status === 401) {
                        err = eval("(" + xhr.responseText + ")");
                        sweetAlert('error', 'Oops...', err.message );
                        return false;
                    }

                    sweetAlert('error', 'Oops...', 'Something went wrong!');
                },
                complete: function () {
                    $this.button('reset');
                    //$("html, body").animate({scrollTop: 0}, "slow");
                }
            });
        }

    });

    $(document).on("click", ".buynow", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.attr('data-product');
        var quantity = $('#quantity').val();
        quantity = quantity ? quantity : 1;
        var select = document.getElementById("select_size");
        if (document.querySelector('input[name="size"]:checked')) {
            var size = document.querySelector('input[name="size"]:checked').value;
        }

        if (product) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('cart.buy')  }}",
                data: {
                    product: product,
                    quantity: quantity,
                    size: size
                },
                beforeSend: function (data) {
                    $this.button('loading');
                },
                success: function (data) {
                    if (data.status) {
                        location.href="{{ route('checkout') }}";
                    }

                    UpdateMiniCart();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var err;
                    if (xhr.status === 401) {
                        err = eval("(" + xhr.responseText + ")");
                        sweetAlert('error', 'Oops...', err.message );
                        return false;
                    }

                    sweetAlert('error', 'Oops...', 'Something went wrong!');
                },
                complete: function () {
                    $this.button('reset');
                    //$("html, body").animate({scrollTop: 0}, "slow");
                }
            });
        }

    });

    </script>

@endsection