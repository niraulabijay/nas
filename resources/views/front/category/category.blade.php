@extends('layouts.app')
@if(isset($category))
@section('title')
    {{ $category->title }}
@stop
@section('site_description')
    {{ $category->description }}
@stop
@section('site_title')
    {{ $category->name }}
@stop
@endif


@section('content')

<style>
.mblfilter{
    display:none;
    
}
    @media screen and (max-width: 425px){
.left__side {
    display: none;
}
#category-filter .product_sort_by{
    display:none;
}
.mblfilter{
    display:block;
}
}


.mblfilter .row{
    background:#fff;
}
.mblfilter .wrapperfilter{
    width:50%;
    padding:5px;
}
.mblfilter .filterwrap p{
    text-align:right;
}


</style>
<section class="mblfilter">
    <div class="container demo">
        <div class="row">
             <div class="wrapperfilter" style="width:50%;">
             <div class="popwrap"><p>Sort By</p></div>
            </div>
            
            <div class="wrapperfilter" style="width:50%;">
                
             <div class="filterwrap">
                      <p data-toggle="modal" data-target="#exampleModal">
  <i class="fas fa-filter"></i> Filter
            </p>
           </div>
           
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:80%; float:right;">
    <div class="modal-content">
      <div class="modal-header" style="padding:5px;">
        <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#c64732;">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      </div>
    
    </div>
  </div>
</div>
  
     
    </div> 
</section>
<style>
    .catimatop ul{
        display:inline-flex;
            max-width: 100%;
    width: 100%;
    }
    .catimatop ul li{
          width: 14.28%;
    border-right: 1px solid #eee;
    text-align: center;
    overflow: hidden;
    padding: 8px 0;
    }
    .catimatop ul li:last-child{border-right:none;}
    .img-cat-wrap img{
        max-width: 100px;
    max-height: 100px;
    overflow: hidden;
    }
    .cat-title-wrap{
    color: #1e1e1e;
    font-size: 16px;
    width: 100%;
    font-family: roboto;
    overflow: hidden;
    -o-text-overflow: ellipsis;
    text-overflow: ellipsis;
    }
    .catimatop{
            margin: 10px 0 0;
    border: 1px solid #ececec;
    border-radius: 3px;
    box-shadow: 0 2px 4px rgba(0,0,0,.05);
    zoom: 1;
    }
          @media screen and (max-width: 425px){
.catimatop {
    display: none;
}
}
#metatitlewrap{  
font-size: 20px;
    font-family: roboto;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom:-20px;
}
#text-muted-new{
        white-space: nowrap;
    -o-text-overflow: ellipsis;
    text-overflow: ellipsis;
    max-width: 600px;
    overflow: hidden;
    font-size: 14px !important;
    font-family: roboto;
    margin-left:0px !important;
}
.nsortingdrop label{
  
    font-size: 14px !important;
    font-family: roboto;

}
.nsortingdrop select{
        padding: 5px;
    border-radius: 3px;
}
</style>
    <section id="category-filter">
        <div class="container" style="background:#fff;">
            <div class="row">
                <div class="col-lg-12">
                     <section class="breadcrumbs" style="padding:10px 0;">
                        <ul class="uk-breadcrumb">
                            <li id="catbreadcrumb"><a href="{{ route('home.index') }}">Home</a></li>
                            <li id="catbreadcrumb"><a href="#">Category</a></li>
                            <li id="catbreadcrumbspan"><span>{{ $title }}</span></li>
                            
                        </ul>
                    </section>
                </div>
                <!--<div class="col-lg-12">-->
                <!--    <div class="catimatop">-->
                <!--        <ul style="display:inline-flex;">-->
                <!--            <li>-->
                <!--                <a href="#">-->
                <!--                    <div class="img-cat-wrap">-->
                <!--                        <img src="https://nepalallshop.com.np/uploads/product/images/f/b/l/medium-15614554791.jpg">-->
                <!--                    </div>-->
                <!--                    <div class="cat-title-wrap">-->
                <!--                        <p>Category</p>-->
                <!--                    </div>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a href="#">-->
                <!--                    <div class="img-cat-wrap">-->
                <!--                        <img src="https://nepalallshop.com.np/uploads/product/images/f/b/l/medium-15614554791.jpg">-->
                <!--                    </div>-->
                <!--                    <div class="cat-title-wrap">-->
                <!--                        <p>Category</p>-->
                <!--                    </div>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a href="#">-->
                <!--                    <div class="img-cat-wrap">-->
                <!--                        <img src="https://nepalallshop.com.np/uploads/product/images/f/b/l/medium-15614554791.jpg">-->
                <!--                    </div>-->
                <!--                    <div class="cat-title-wrap">-->
                <!--                        <p>Category</p>-->
                <!--                    </div>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a href="#">-->
                <!--                    <div class="img-cat-wrap">-->
                <!--                        <img src="https://nepalallshop.com.np/uploads/product/images/f/b/l/medium-15614554791.jpg">-->
                <!--                    </div>-->
                <!--                    <div class="cat-title-wrap">-->
                <!--                        <p>Category</p>-->
                <!--                    </div>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a href="#">-->
                <!--                    <div class="img-cat-wrap">-->
                <!--                        <img src="https://nepalallshop.com.np/uploads/product/images/f/b/l/medium-15614554791.jpg">-->
                <!--                    </div>-->
                <!--                    <div class="cat-title-wrap">-->
                <!--                        <p>Category</p>-->
                <!--                    </div>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a href="#">-->
                <!--                    <div class="img-cat-wrap">-->
                <!--                        <img src="https://nepalallshop.com.np/uploads/product/images/f/b/l/medium-15614554791.jpg">-->
                <!--                    </div>-->
                <!--                    <div class="cat-title-wrap">-->
                <!--                        <p>Category</p>-->
                <!--                    </div>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a href="#">-->
                <!--                    <div class="img-cat-wrap">-->
                <!--                        <img src="https://nepalallshop.com.np/uploads/product/images/f/b/l/medium-15614554791.jpg">-->
                <!--                    </div>-->
                <!--                    <div class="cat-title-wrap">-->
                <!--                        <p>Category</p>-->
                <!--                    </div>-->
                <!--                </a>-->
                <!--            </li>-->
                <!--        </ul>-->
                <!--    </div>-->
                <!--</div>-->
                  <div class=" col-lg-2 col-md-2 col-sm-12  ">
                    <aside class="left__side mb">
                        <div class="filter-section mb">
                            <div class="filter-title d-flex justify-content-between">
                               
                            </div>

                            <div class="filter-result">

                            </div>
                        </div>
                        <ul uk-accordion="multiple: true" class="mobile-accord">
                           

                            @if($products->count()>0)
                                @if(isset($brands))
                                    @include('front.category.filter.brands',['brands'=>$brands])
                                @endif
                                @include('front.category.filter.discount')
                                @if(isset($size))
                                    @include('front.category.filter.size')
                                @endif
                                @if(isset($colour) && $colour->isNotEmpty())
                                    @include('front.category.filter.colour',['colour'=>$colour])
                                @endif
                            @endif                            
                        </ul>

                    </aside>

                </div>
                <div class=" col-lg-10 col-md-10" style="background:#fff;">
                   
                    <div class="Name__of__category mt-2">
                        <div class="heading d-flex" style="display:block !important;">
                            <h3 id="metatitlewrap">{{ $title }} </h3>
                            </br>
                            <div>
                            <span class="text-muted" id="text-muted-new">Showing {{ count($products) }} products</span>
                            <div class="nsortingdrop float-right">
                                <label>Sort By:</label>
                                <select class="sorting" data-width="fit">
                                 <option data-content='Popularity'>Popularity</option>
                                 <option  data-content='Price high to low'>Price high to low</option>
                                 <option  data-content='Price low to high'>Price low to high</option>
                                </select>
                            </div>
                            </div>
                        </div>

                    </div>
<script>
    $(function(){
    $('.sorting').sorting();
});
</script>
<style>
/* Style the buttons */
.item-fliter-top {
 border: none;
    outline: none;
    margin: 0px 5px !important;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    padding: 5px 0px !important;
    cursor: pointer;
    font-size: 13px !important;
    font-family:roboto;
}

/* Style the active class, and buttons on mouse-over */
.item-fliter-top.live, a.item-fliter-top:hover {
 color: #c64732 !important;
    font-family: roboto;
    font-weight: bold;
    font-size: 14px !important;
}


</style>
                    <div class="product_sort_by my-2 border-bottom">
                        <div class="d-flex justify-content-start align-items-center" style="display:none !important">
                            <div class="heading">
                                <h3>Sort by:</h3>
                            </div>
                            <ul class="d-flex" id="d-flex">
                                
                                <li><a class="item_filter item-fliter-top live" data-sort="new" href="#">Newest Items</a></li>
                                <li><a class="item_filter item-fliter-top " data-sort="low-high" href="#">Price low to high</a></li>
                                <li><a class="item_filter item-fliter-top" data-sort="high-low" href="#">Price high to low</a></li>
                                <!--<li><a class="item_filter item-fliter-top" data-sort="a-z" href="#">Alphabetical: A to Z</a></li>-->
                                <!--<li><a class="item_filter item-fliter-top" data-sort="z-a" href="#">Alphabetical: Z to A</a></li>-->
                            </ul>
                        </div>
                    </div>

                    {{-- <div class=" high-low-container pull-right">
                        <form action="{{ Request::fullUrl()}}" method="get">
                            <label for="sort"></label>
                            <select class="uk-select item_filter" name="sort" id="sort">
                                <option selected>Sort By</option>
                         
                                <option class="item_filter item-fliter-top" value="new">Newest Items</option>
                                <!--<option class="item_filter item-fliter-top" value="old">Oldest Items</option>-->
                                <!--<option class="item_filter item-fliter-top" value="a-z">Alphabetical: A to Z</option>-->
                                <!--<option class="item_filter item-fliter-top" value="z-a">Alphabetical: Z to A</option>-->
                                <option class="item_filter item-fliter-top" value="low-high">Price: Low to High</option>
                                <option class="item_filter item-fliter-top" value="high-low">Price: High to Low</option>
                            </select>
                        </form>
                    </div> --}}
                    <div class="clearfix"></div>
                    <div class="product-category white-product" id="productData">
                        @include('front.category.product',['product' => $products])
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="quickview-modal" class="product-description" uk-modal>
    </div>

    <style>
        #loaderpro {
            text-align: center;
            background: url({{ asset('uploads/giphy.gif') }}) no-repeat center;
            height: 150px;
        }
    </style>

@endsection
@section('extra_scripts')

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


        $(document).on('click', '.item_filter', function () {
            $this = $(this);
            $('#productData').html('<div id="loaderpro" style="" ></div>');
            colour = multiple_values('colour');
            brand = multiple_values('brand');
            size = multiple_values('size');
            sort = $(this).attr('data-sort');
            $.ajax({
                url: document.URL,
                type: 'get',
                data: {
                    colour: colour,
                    brand: brand,
                    size: size,
                    // sort: $("#sort").val(),
                    sort: sort,
                    maxprice: $("#max").val(),
                    minprice: $("#min").val()
                },
                success: function (result) {
                    $('.item-fliter-top').removeClass('live')
                    $('#productData').replaceWith($('#productData').html(result));
                    
                    $this.addClass('live')
                }
            });
        });

        function multiple_values(inputclass) {
            var val = new Array();
            $("." + inputclass + ":checked").each(function () {
                val.push($(this).val());
            });
            return val;
        }

        $( function () {
            $("#slider-range").slider({
                range: true,
                min: 10,
                max: 100000,
                values: [5000, 30000],
                slide: function (event, ui) {
                    $( "#amount" ).val( "Min : Rs" + ui.values[ 0 ] + " - Max : Rs" + ui.values[ 1 ] );
                    $("#min").val(ui.values[0]);
                    $("#max").val(ui.values[1]);

                    $('.product-data').html('<div id="loaderpro" style="" ></div>');
                    colour = multiple_values('colour');
                    brand = multiple_values('brand');
                    size = multiple_values('size');
                    $.ajax({
                        url: document.URL,
                        type: 'get',
                        data: {
                            colour: colour,
                            brand: brand,
                            size: size,
                            sort: $("#sort").val(),
                            maxprice: $("#max").val(),
                            minprice: $("#min").val()
                        },
                        success: function (result) {
                            $('#productData').replaceWith($('#productData').html(result));
                        }
                    });
                }
            });
            $( "#amount" ).val( "Min : Rs" + $( "#slider-range" ).slider( "values", 0 ) +
            " - Max : Rs" + $( "#slider-range" ).slider( "values", 1 ) );
        });
        

    </script>


@endsection