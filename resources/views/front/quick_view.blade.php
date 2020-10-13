
<div class="uk-modal-dialog uk-modal-body">
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <div class="row">
        <div class="col-md-7">
            <div class="owl-carousel  product-description-slider">
                @foreach( $product->getProductGallery() as $gallery )
                    <figure>
                        <img src="{{ $gallery->mediumUrl }}" alt="">
                    </figure>
                @endforeach
            </div>
        </div>
        <div class="col-md-5" style="height: 571px;overflow-y:auto">
            <div class="summary entry-summary product-details">
                <h1 class="product_title entry-title">
                    <a href="{{ route('product.show', ['slug' => $product->slug]) }}">{{ $product->name }} </a>
                </h1>
                <div class="shear-brand">
                    <div class="item">
                        <div class="product-rating">
                            <div class="star-rating">
                                <span style="width:100%">
                                     @for( $i=0;$i<$product->getAverageRating();$i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    {{--<i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>--}}
                                </span>
                            </div>
                            <a href="#reviews" class="review-link">(<span
                                        class="count">{{$product->reviews->where('status',1)->count()}}</span> customer review)
                            </a>
                        </div>
                        <div class="product-price-container">
                            <p class="price">
                                <del>
                                    <span class="Price-amount amount">
                                        <span class="Price-currencySymbol">Rs. </span>{{ $product->product_price }}
                                    </span>
                                </del>
                                <ins>
                                    <span class="Price-amount amount">
                                        <span class="Price-currencySymbol">Rs. </span>{{ $product->sale_price  }}</span>
                                </ins>
                            </p>
                        </div>

                    </div>
                    <div class="brand-img">
                        <a href="" title="{{ $product->brand->name }}">
                            <img width="150" height="150"
                                 src="{{ $product->brand->getImage()->url }}"
                                 class="attachment-thumbnail size-thumbnail" alt="">
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="product-details__short-description uk-margin-top">
                    <ul>
                        @foreach($product->specifications->take(8) as $specification)
                            <li style="list-style: none;margin-left: -20px;">
                                <label for="" style="text-transform: capitalize">{{ $specification->title }} :</label>
                                <span>{{ $specification->description }}</span>
                            </li>
                        @endforeach

                    </ul>

                </div>


                <div class="row product--details uk-margin-top">
                    @if(!empty($colours))
                        <div class="product__color-box uk-margin-small-bottom">
                            <div class="product--color bold availability">
                                <span>Color</span>
                            </div>
                            <div class="product--color-option">
                                <div class="custom-radios">
                                    @foreach(array_unique($colours)  as $color)
                                        <div>
                                            <input type="radio" id="color-{{$loop->index}}" name="colour" value="{{$color}}">
                                            <label for="color-{{ $loop->index }}" style="margin-bottom:0">
                                                <span style="background-color: {{ $color }};height:20px;width:20px;display:block;border: 1px solid gainsboro;"></span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($sizes))
                        <div class="product__size-box bold uk-margin-small-bottom">
                            <div class="product--size availability">
                                Size
                            </div>
                            <div class="product--size-value">
                                <div class="custom-select">
                                    <select id="select_size" class="uk-select">
                                        <option disabled="">select Size</option>

                                        @foreach(array_unique($sizes) as $size)
                                            <option value="{{ $size }}">{{ $size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="btn-details-action">
                    <form class="cart" method="post" enctype="multipart/form-data">
                        <div class="quantity">
                            <input type="number" id="quantity" class="input-text qty text" step="1" min="1" max="{{ $product->stock_quantity }}" name="quantity" value="1" title="Qty" size="4">
                        </div>
                        <a class="uk-button add_to_cart_button ajax_add_to_cart" href="#" data-product="{{$product->id}}">Add to cart</a>
                    </form>
                </div>


                <div class="product_meta uk-margin-top">
                    <ul class="liststyle--none">
                        <li><span class="sku_wrapper">SKU: <span class="sku">{{ $product->sku }}</span></span>
                        </li>
                        <li>
                            <span class="posted_in">Category:
                                @foreach($product->categories as $pcat)
                                    {{ $loop->first ? '' : '|' }} <a href="{{ url('/') . '/category/' . $pcat->slug }}">{{ $pcat->name }}</a>
                                @endforeach
                            </span>
                        </li>
                    </ul>
                </div>
                <ul class="liststyle--none social-icons uk-margin-top">
                    <li>
                        Share on:
                    </li>
                    <li class="social-icon ">
                        <a class="facebook fab fa-facebook-square" href="" target="_blank">

                        </a>
                    </li>
                    <li class="social-icon">
                        <a class="twitter fab fa-twitter-square" href="" target="_blank">

                        </a>
                    </li>
                    <li class="social-icon ">
                        <a class="googleplus fab fa-google-plus-square" href="" target="_blank">

                        </a>
                    </li>
                    <li class="social-icon ">
                        <a class="linkedin fab fa-linkedin" href="" target="_blank">

                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.main-slider').owlCarousel({
            loop:true,
            margin:0,
            nav:false,
            items:1,
            animateOut: 'fadeOut',
            autoplay:true,
            smartSpeed:1000,
            dots:true,
            navText : ["<i class='fas fa-angle-left fa-2x'></i>","<i class='fas fa-angle-right fa-2x'></i>"],
            responsive:{
                0:{
                    items:1
                }
            }
        });

        $('.product-description-slider').owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            items:1,
            autoplay:true,
            smartSpeed:2000,
            dots:true,
            navText : ["<span uk-icon=\"icon: arrow-left\"></span>","<span uk-icon=\"icon: arrow-right\"></span>"],
            responsive:{
                0:{
                    items:1
                }
            }
        });
        $('.product-elementor-slider').owlCarousel({
            loop:true,
            margin:0,
            nav:false,
            items:1,
            autoplay:true,
            smartSpeed:2000,
            dots:true,
            navText : ["<i class='fas fa-angle-left fa-2x'></i>","<i class='fas fa-angle-right fa-2x'></i>"],
            responsive:{
                0:{
                    items:1
                }
            }
        });
        $('.dealofday-carousel').owlCarousel({
            loop:true,
            margin:5,
            nav:true,
            items:6,
            pagination: false,
            autoplay:false,
            smartSpeed:1000,
            navText : ["<i class='fa fa-chevron-left fa-1x'></i>","<i class='fa fa-chevron-right fa-1x'></i>"],
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                400:{
                    items:2
                },
                600:{
                    items:3
                },
                1000:{
                    items:6
                }
            }
        });
        $('.product-carousel').owlCarousel({
            loop:true,
            margin:5,
            nav:true,
            items:4,
            pagination: false,
            autoplay:false,
            smartSpeed:1000,
            navText : ["<i class='fa fa-chevron-left fa-1x'></i>","<i class='fa fa-chevron-right fa-1x'></i>"],
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                400:{
                    items:2
                },
                600:{
                    items:3
                },
                1000:{
                    items:6
                }
            }
        });
        $('.customers-testimonials').owlCarousel({
            loop: true,
            center: true,
            items: 1,
            nav:true,
            navText : ["<i class='fas fa-angle-left fa-2x'></i>","<i class='fas fa-angle-right fa-2x'></i>"],
            margin: 0,
            autoplay: true,
            dots:true,
            autoplayTimeout: 8500,
            smartSpeed: 500,
            responsive: {
                0: {
                    items: 1
                }
            }
        });

        $('.owl-carousel').owlCarousel({
            loop:true,
            // margin:10,
            nav:true,
            items:4,
            pagination: false,
            autoplay:false,
            smartSpeed:1000,
            navText : ["<i class='fa fa-chevron-left fa-1x'></i>","<i class='fa fa-chevron-right fa-1x'></i>"],
            dots:true,
            responsive:{
                0:{
                    items:1
                },
                400:{
                    items:2
                },
                600:{
                    items:3
                },
                1000:{
                    items:4
                }
            }
        });

    });
</script>