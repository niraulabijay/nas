@if($products->count()>0)
@foreach($products as $product)
<!--custom css by Rahul-->
<style>
    article{
             padding: 0 0px;
    position: relative;
    overflow: hidden;
    margin: 0px 0 0px;
    height: 280px;
    }
    .product-wrap{
            position: absolute;
    padding-bottom: 10px;
    }
    .product-category.white-product .product-description{
        padding-bottom:0px !important;
    }
    .addtocatbtn{
    background: #c64732;
    width: 90%;
    padding: 5px;
    font-family: roboto;
    font-size: 16px;
    border: none;
    margin-bottom: 10px;
    color: #fff;
    border-radius: 2px;
    font-weight: 500;
    }
</style>


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
                        
                        <div class="row"> 
                        <div class="col-md-12">
                        <p class="product-title">
                            <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="line-clamp1" >{{ $product->name }}</a>
                        </p>
                        </div>
                        
                            </div>
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
            <div class="c2attd"><div class="c31VUX"><button age="0" type="button" class="addtocatbtn">ADD TO CART</button></div></div>
        </div>
    </article>
    <style>
    .c2attd {
    margin-top: 10px;
    visibility: hidden;
    text-align: center;
    display: none;
}
.c1xzE_, .c31VUX {
    position: relative;
}
.product:hover .product-wrap .c2attd {
    visibility: visible;
    display: block;
}
    </style>
@endforeach

<div class="clearfix"></div>
<div class="pagination-wrapper" style="width:100%">
    <div class="pagination">
        {{ $products->setPath(Request::fullUrl() )->links() }}
    </div>
</div>
@else
    <div class="product-category white-product">
        <div class="alert alert-danger alert-status text-center">No Products Found</div>
    </div>
@endif