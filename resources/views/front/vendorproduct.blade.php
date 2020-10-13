@extends('layouts.app')
@section('title', 'Nepal All Shop')

@section('content')

    <section id="category-filter">
        <div class="container-fluid">
            <div class="row">
                <div class=" col-lg-2 col-md-3 col-sm-12  ">
                    <aside class="left__side mb">
                        
                    
                        <ul uk-accordion="multiple: true" class="mobile-accord">
                              <li class="uk-open">
                                    <a class="uk-accordion-title" href="#">
                                        <h5> Category</h5>
                                    </a>
                                    <div class="uk-accordion-content">
                                        <div class="scrollbar   mCustomScrollbar">
                                            <ul>
                                                @foreach($categories as $category)
                                                <li class="category-list">
                                                    <a class="link-category" href="{{route('category',['slug'=>$category->slug])}}">{{$category->name}}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            
                            <ul uk-accordion="multiple: true" class="mobile-accord">
                              <li class="uk-open">
                                    <a class="uk-accordion-title" href="#">
                                        <h5> Brands</h5>
                                    </a>
                                    <div class="uk-accordion-content">
                                        <div class="scrollbar   mCustomScrollbar">
                                            <ul>
                                                @foreach($brands as $brand)
                                                <li class="category-list">
                                                    <a class="link-category" href="{{route('brand',['slug'=>$brand->slug])}}">{{$brand->name}}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                    </aside>

                </div>
                <div class=" col-lg-10 col-md-9 box-shadow-xy">
                   
                     <section class="breadcrumbs ">
                        <ul class="uk-breadcrumb">
                            <li><a href="{{ route('home.index') }}">Home</a></li>
                            <li><a href="#">Vendor</a></li>
                            <li><span>{{ $vendor }}</span></li>
                        </ul>
                    </section>
                    <div class="Name__of__category mt-2">
                        <div class="heading d-flex" style="justify-content: center;">
                            <h3>{{ $vendor }} </h3><span class="text-muted">(showing {{ count($products) }} products)</span>
                        </div>

                    </div>
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
                    $('#productData').replaceWith($('#productData').html(result));
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