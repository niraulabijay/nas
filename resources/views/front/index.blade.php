@extends('layouts.app')
@section('title', getConfiguration('site_title'))

@section('content')

    <div  id="slide-banner" style="background: #b8bcc1;
    opacity: 0.9;">
        <div class="container" id="sliding_banner" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($slideshows as $slideshow)
                <li data-target="#sliding_banner" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach

            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach($slideshows as $slideshow)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}" >
                    @if(!empty($slideshow->link))
                        <a href="{{ $slideshow->link }}"> <img src="{{ url('/').$slideshow->image }}" alt=""></a>
                    @else
                        <a href="#">
                            <img src="{{ url('/').$slideshow->image }}">
                        </a>
                    @endif

                </div>
                @endforeach
            </div>
            <!--<div class="owl-nav">-->
            <!--    <button type="button" role="presentation" class="owl-prev">-->
            <!--        <i class="fa fa-chevron-left fa-1x"></i>-->
            <!--        </button>-->
            <!--    <button type="button" role="presentation" class="owl-next">-->
            <!--        <i class="fa fa-chevron-right fa-1x"></i>-->
            <!--        </button>-->
            <!--    </div>-->
            <a class="carousel-control-prev" href="#sliding_banner" role="button" data-slide="prev" style="opacity:1;display:none;">
                <span class="carousel-control-prev-icon" style="background-image: none;" aria-hidden="true">
                    <i class="fa fa-chevron-left fa-1x" style="font-size: 35px;
    color: #000; background: #fff;padding: 20px 15px;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    margin-left: -150px;
    top: -10;
    margin-top: -31px;
    opacity: 0.9;"></i>
                </span>
                <span class="sr-only">Previous</span>
            </a>
            
            
            <a class="carousel-control-next" href="#sliding_banner" role="button" data-slide="next" style="opacity:1; display:none;">
                <span class="carousel-control-next-icon" style="background-image: none;" aria-hidden="true">
                    <i class="fa fa-chevron-right fa-1x" style="font-size: 35px;
    color: #000; background: #fff;padding: 20px 15px;
    border-bottom-left-radius: 4px;
    border-top-left-radius: 4px;
    margin-right: -150px;
    top: -10;
    margin-top: -31px;
    opacity: 0.9;"></i>
                </span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <section class="product-grid dealofday mb" style="background: #f7f7f7 !important;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 product--grid">
                    <div class="product-grid-content">
                        
                        <div class="countdown float-left">
                            <h5>Deal of the day</h5>
                        </div>
                        @php
                            $category = \App\Model\Category::where('name', getHome('products_section_1'))->first();
                        @endphp
                    
                            <a href="#" class="float-right view-more">view more</a>
                   
                        <div class="clearfix"></div>
                    </div>
                    <div class="product-category white-product">
                        <div class="container">
                            <div class="owl-carousel dealofday-carousel inner-column">
                                @foreach(getProductsByCategory(getHome('products_section_1')) as $product)
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
                                                             class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}" data-src="{{ asset('img/nas-preimage.png') }}">
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
                <div class="col-lg-2 col-md-3 col-sm-4 d-none d-sm-block" style="display:none !important;">
                    <div class="side--image">
                        <a href="{{ getConfiguration('category_ads_link_1') }}"><img src="{{ url('storage') . '/' . getConfiguration('category_ads_image_1') }}" alt="image"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <!--<section class="category-product-selected">-->
   <!--    <div class=container>-->
   <!--        <div class="row">-->
   <!--            <div class="col-md-2">-->
   <!--                <a href="#">-->
   <!--                <div class="cat--wrap" style="background: #fff;padding: 10px;text-align: center;">-->
   <!--                    <div class="cat--img-wrap">-->
   <!--                        <img src="https://static-01.daraz.com.np/original/cf5043f98312ae860a40274dc62086ce.jpg" alt="Ncat Image" style="padding:10px;">-->
   <!--                        <span>T-Shirt</span>-->
   <!--                    </div>-->
   <!--                </div>-->
   <!--                </a>-->
   <!--            </div>-->
               
   <!--        </div>-->
   <!--    </div>-->
   <!--</section>-->
   
   <style>
   .cat-li-wrap ul{
       display:inline-flex;
   }
       .cat-li-wrap ul li{
           width:14%;
           border-right:1px solid #eee;
       }
       .cat-li-wrap ul li:last-child{
           border-right:none;
       }
       .cat-li-wrap .cat--wrap{
           background: #fff;
           padding: 10px;
           text-align: center;
       }
       .cat--img-wrap img{
           
       }
       .cat--img-wrap span{
           white-space:nowrap;
       }
       @media screen and (max-width: 425px){
.cat--list {
    display: none;
}
.banner-wrap-front{
    display:none;
}
.long-banner-wrap{
    display:none;
}
}
.banner-image-wrap {
   
    border-radius: 4px;
    box-shadow: 2px 2px 4px 0 rgba(0,0,0,.08);
}
.banner-wrap-front .col-md-3{
    padding:0px 5px ;
    
   }
   .long-banner img{
       box-shadow:2px 2px 4px 0rgba(0,0,0,.08);
       /*border-radius:4px;*/
       border:1px solid #eee;
   }
   .product-category.white-product .product-top figure .product-image{
       width:150px;
   }
   article{
       padding:10px;
   }
   .product-category.white-product .product-wrap:hover{
       box-shadow: 0 2px 4px 0 rgba(0,0,0,.25);
       
   }
    .cat-li-wrap li:hover{
         box-shadow: 0 2px 4px 0 rgba(0,0,0,.25);
    }
    .nav-category li:last-child{display:none;}
    .cat-li-wrap{
        background:#fff;
        padding:10px;
    }
    .cat-li-wrap h2{
        border-bottom: 1px solid #eee;
    margin-bottom: 10px;
    }
    .product-grid-content{
        border-bottom: 1px solid #eee;
    margin-bottom: 10px;
    }
   </style>
     <section class="long-banner-wrap" style="margin-bottom:10px !important">
        <div class="container">
            <div class="row">
                <div class="long-banner" style="
    border: 1px solid #eee;
">
                    <img src="https://nepalallshop.com.np/slideshow/4kxJAf0OhmwWGHLg31rti2mQwlccmeyJU2QvtIBb.png" alt="img-long">
                </div>
            </div>
        </div>
    </section>
    <section class="cat--list" style="margin-bottom:10px !important">
        <div class="container">
            <div class="cat-li-wrap">
                <h2>Trending Category</h2>
                <ul style="    display: inline-flex;border-bottom: 1px solid #eee;">
                    <!--first-->
                    <li>
                         <a href="https://nepalallshop.com.np/category/headphones-headsets">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/c/g/4/medium-1.jpg" alt="Ncat Image">
                           <span>Earpod</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--second-->
                     <li>
                         <a href="https://nepalallshop.com.np/category/toys">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/b/5/8/medium-TANK-BL.jpg" alt="Ncat Image">
                           <span>Toys</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--third-->
                     <li>
                         <a href="https://nepalallshop.com.np/category/men-s-grooming">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/3/w/u/medium-15614463501.jpg" alt="Ncat Image">
                           <span>Trimmer</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--fourth-->
                     <li>
                         <a href="https://nepalallshop.com.np/category/sandals-floaters">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/r/j/6/medium-15609377521.jpg" alt="Ncat Image">
                           <span>Slippers</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--fifth-->
                     <li>
                         <a href="https://nepalallshop.com.np/category/sports-t-shirts">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/2/s/h/medium-1.jpg" alt="Ncat Image">
                           <span>Jersey</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--sixth-->
                     <li>
                         <a href="https://nepalallshop.com.np/category/beauty-grooming">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/x/f/r/medium-15614547571.jpg" alt="Ncat Image">
                           <span>Beauty & Grooming</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--seventh-->
                     <li>
                         <a href="https://nepalallshop.com.np/category/food-suppliments">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/p/k/l/medium-1.jpg" alt="Ncat Image">
                           <span>Hookah</span>
                       </div>
                   </div>
                   </a>
                    </li>
                 
                </ul>
                 <ul style="    display: inline-flex;">
                    <!--first-->
                    <li>
                         <a href="https://nepalallshop.com.np/category/musical-instruments">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/b/w/v/medium-1.jpg" alt="Ncat Image">
                           <span>Musical Intruments</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--second-->
                     <li>
                         <a href="#">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/c/s/u/medium-1.jpg" alt="Ncat Image">
                           <span>Shoes</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--third-->
                     <li>
                         <a href="#">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/v/y/i/medium-1.jpg" alt="Ncat Image">
                           <span>Sunglass</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--fourth-->
                     <li>
                         <a href="#">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/l/w/q/medium-1.jpg" alt="Ncat Image">
                           <span>Speaker</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--fifth-->
                     <li>
                         <a href="#">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/z/0/1/medium-royal-gold-day-date-men-s-nf9117-naviforce-original-imaf67zmacwyxznt.jpeg" alt="Ncat Image">
                           <span>Watch</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--sixth-->
                     <li>
                         <a href="#">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/o/3/5/medium-1.jpg" alt="Ncat Image">
                           <span>Jackets</span>
                       </div>
                   </div>
                   </a>
                    </li>
                    <!--seventh-->
                     <li>
                         <a href="#">
                   <div class="cat--wrap">
                       <div class="cat--img-wrap">
                           <img src="https://nepalallshop.com.np/uploads/product/images/o/x/h/medium-8.Technic-tropicana-lipstick.jpg" alt="Ncat Image">
                           <span>Beauty Care</span>
                       </div>
                   </div>
                   </a>
                    </li>
                 
                </ul>
            </div>
        </div>
    </section>
    
  

    @if(getProductsByCategory(getHome('products_section_2'))->isNotEmpty())
    <section class=" category mb" style="margin-bottom:10px !important">
        <div class="container">
            <div class="#">
                <div class="category-title border_bottom">
                    <div class="category--title float-left">
                        <h5>{{ getHome('products_section_2') }}</h5>
                    </div>
                    @php
                        $category = \App\Model\Category::where('name', getHome('products_section_2'))->first();
                    @endphp
                    @if($category)
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="float-right view-more">view more</a>
                    @endif
                    <div class="clearfix"></div>
                </div>
                
                
                <div class="product-category white-product">

                    <div class="owl-carousel categories">
                        @foreach(getProductsByCategory(getHome('products_section_2')) as $product)
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
                                                     class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}" data-src="{{ asset('img/nas-preimage.png') }}">
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
    @endif
    
    <!--banner-->
    <section class="banner-wrap-front" style="margin-bottom:10px !important">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="banner-image-wrap">
                        <img src="https://nepalallshop.com.np/storage/settings/is3pVyDxoelHfT7TeEM1YYNiYn5nc3ksV9g3GGJx.png" alt="banner">
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="banner-image-wrap">
                        <img src="https://nepalallshop.com.np/storage/settings/rLw2fZXaB5BNzNqcdcI8apWo2kcOBpnZwqXxZpI6.png" alt="banner">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="banner-image-wrap">
                        <img src="https://nepalallshop.com.np/storage/settings/p3MFkbvDP4sHE2xJgvyNLSgj6Uc44w9sCa1JQEFM.png" alt="banner">
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="banner-image-wrap">
                        <img src="https://nepalallshop.com.np/storage/settings/VDhNwHA32TUGzyN7xvg5tWvemOyH7RLbptXhD8hA.png" alt="banner">
                    </div>
                </div>
            </div>
             </div> 
    </section>
    <section class=" feature_brand mb">
        <div class="container-fluid">
            <div class=" box-shadow">
                <div class="category-title ">
                    <div class="category--title float-left">
                        <h5>Feature Brand</h5>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
               <div class="feature_brand_list owl-carousel p-3">
                    @foreach($brands as $brand)
                        <div class="brand-img" style="height: 150px;">
                            <a href="{{ route('brand', $brand->slug) }}"><img src="{{ asset('uploads/brands/documents/'. $brand->document) }}" alt="{{ $brand->name }}" style="width: auto;margin: 0 auto;"></a>
                        </div>
                   @endforeach
               </div>
            </div>
        </div>
    </section>

    @if(getProductsByCategory(getHome('products_section_3'))->isNotEmpty())
    <section class=" category mb" style="margin-bottom:10px !important">
        <div class="container">
            <div class="#">
                <div class="category-title border_bottom">
                    <div class="category--title float-left">
                        <h5>{{ getHome('products_section_3') }}</h5>
                    </div>
                    @php
                        $category = \App\Model\Category::where('name', getHome('products_section_3'))->first();
                    @endphp
                    @if($category)
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="float-right view-more">view more</a>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="product-category white-product">

                    <div class="owl-carousel categories">
                        @foreach(getProductsByCategory(getHome('products_section_3')) as $product)
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
                                                     class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}" data-src="{{ asset('img/nas-preimage.png') }}">
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
    @endif

    @if(getProductsByCategory(getHome('products_section_4'))->isNotEmpty())
    <section class=" category mb" style="margin-bottom:10px !important">
        <div class="container">
            <div class="#">
                <div class="category-title border_bottom">
                    <div class="category--title float-left">
                        <h5>{{ getHome('products_section_4') }}</h5>
                    </div>
                    @php
                        $category = \App\Model\Category::where('name', getHome('products_section_4'))->first();
                    @endphp
                    @if($category)
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="float-right view-more">view more</a>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="product-category white-product">

                    <div class="owl-carousel categories">
                        @foreach(getProductsByCategory(getHome('products_section_4')) as $product)
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
                                                     class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}" data-src="{{ asset('img/nas-preimage.png') }}">
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
    @endif
<section class="long-banner-wrap" style="margin-bottom:10px !important">
        <div class="container">
            <div class="row">
                <div class="long-banner" style="
    border: 1px solid #eee;
">
                    <img src="https://nepalallshop.com.np/storage/settings/sphYtzg4kllEYlwSSEppY9du9cXUufMCKWFfdiXa.jpeg" alt="img-long">
                </div>
            </div>
        </div>
    </section>
    @if(getProductsByCategory(getHome('products_section_5'))->isNotEmpty())
    <section class=" category mb" style="margin-bottom:10px !important">
        <div class="container">
            <div class="#">
                <div class="category-title border_bottom">
                    <div class="category--title float-left">
                        <h5>{{ getHome('products_section_5') }}</h5>
                    </div>
                    @php
                        $category = \App\Model\Category::where('name', getHome('products_section_5'))->first();
                    @endphp
                    @if($category)
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="float-right view-more">view more</a>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="product-category white-product">

                    <div class="owl-carousel categories">
                        @foreach(getProductsByCategory(getHome('products_section_5')) as $product)
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
                                                     class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}" data-src="{{ asset('img/nas-preimage.png') }}">
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
    @endif


    @if(getProductsByCategory(getHome('products_section_6'))->isNotEmpty())
    <section class=" category mb" style="margin-bottom:10px !important">
        <div class="container">
            <div class="#">
                <div class="category-title border_bottom">
                    <div class="category--title float-left">
                        <h5>{{ getHome('products_section_6') }}</h5>
                    </div>
                    @php
                        $category = \App\Model\Category::where('name', getHome('products_section_6'))->first();
                    @endphp
                    @if($category)
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="float-right view-more">view more</a>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="product-category white-product">

                    <div class="owl-carousel categories">
                        @foreach(getProductsByCategory(getHome('products_section_6')) as $product)
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
                                                     class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}" data-src="{{ asset('img/nas-preimage.png') }}">
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
    @endif
  <section class="banner-wrap-front" style="margin-bottom:10px !important">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="banner-image-wrap">
                        <img src="https://nepalallshop.com.np/storage/settings/SSZWDhvDUxuzUZShs1OMaxZ2QNuS7NxgTj6oeSEr.png" alt="banner">
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="banner-image-wrap">
                        <img src="https://nepalallshop.com.np/storage/settings/DOKhNdRxKV0RdTaxQow9ayEIvZvmfhXiFOR2D1Wp.png" alt="banner">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="banner-image-wrap">
                        <img src="https://nepalallshop.com.np/storage/settings/OILXgA1MNNk1N5tSalxukgW6aIYxTxNTf6HtPxYW.png" alt="banner">
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="banner-image-wrap">
                        <img src="https://nepalallshop.com.np/storage/settings/VBJsPqHMwjhhNDIkq0MgzLS0dEuGEUf0zFM9pUxj.png" alt="banner">
                    </div>
                </div>
            </div>
             </div> 
    </section>
    @if(getProductsByCategory(getHome('products_section_7'))->isNotEmpty())
    <section class=" category mb" style="margin-bottom:10px !important">
        <div class="container">
            <div class="#">
                <div class="category-title border_bottom">
                    <div class="category--title float-left">
                        <h5>{{ getHome('products_section_7') }}</h5>
                    </div>
                    @php
                        $category = \App\Model\Category::where('name', getHome('products_section_7'))->first();
                    @endphp
                    @if($category)
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="float-right view-more">view more</a>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="product-category white-product">

                    <div class="owl-carousel categories">
                        @foreach(getProductsByCategory(getHome('products_section_7')) as $product)
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
                                                     class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}" data-src="{{ asset('img/nas-preimage.png') }}">
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
    @endif

    @if(getProductsByCategory(getHome('products_section_8'))->isNotEmpty())
    <section class=" category mb" style="margin-bottom:10px !important">
        <div class="container">
            <div class=" #">
                <div class="category-title border_bottom">
                    <div class="category--title float-left">
                        <h5>{{ getHome('products_section_8') }}</h5>
                    </div>
                    @php
                        $category = \App\Model\Category::where('name', getHome('products_section_8'))->first();
                    @endphp
                    @if($category)
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="float-right view-more">view more</a>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="product-category white-product">

                    <div class="owl-carousel categories">
                        @foreach(getProductsByCategory(getHome('products_section_8')) as $product)
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
                                                     class="attachment-shop_catalog size-shop_catalog" alt="{{ $product->name }}" data-src="{{ asset('img/nas-preimage.png') }}">
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
    @endif

    @if(count($seos) > 0)
    <section class="testimonial">
        <div class="container-fluid">
            <div class="row relative">
                <div class="col-md-12 col-sm-12">
                    <div class="meta__tags">
                        @foreach($seos as $seo)
                        <a href="{{ $seo->link }}" class="meta-tags">{{ $seo->keyword }}</a>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
        <div class="circle">

        </div>
    </section>
    @endif

    <div id="quickview-modal" class="product-description" uk-modal>
    </div>
@endsection

@section('extra_scripts')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>


    <script type="text/javascript">

        $(document).on('click', '.add_to_wishlist', function (e) {
            e.preventDefault();
            var product = $(this).attr('data-product');
            $(this).delay(5000);
            var wishlistClass = '#wishlist_' + product;
            $(wishlistClass).addClass('remove_from_wishlist');
            $(wishlistClass).removeClass('add_to_wishlist');
        });

        $(document).on('click', '.remove_from_wishlist', function (e) {
            e.preventDefault();
            var product = $(this).attr('data-product');
            $(this).delay(5000);
            var wishlistClass = '#wishlist_' + product;
            $(wishlistClass).addClass('add_to_wishlist');
            $(wishlistClass).removeClass('remove_from_wishlist');
        });
    </script>
    <script>
        function sweetAlert(type, title, message) {
            swal({
                title: title,
                html: message,
                type: type,
                confirmButtonColor: '#ee3d43',
                timer: 3000
            }).catch(swal.noop);
        }

    </script>



@endsection
