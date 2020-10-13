
@role('vendor')
@extends('merchant.layouts.app')

@endrole
@section('title',"Edit Product")
{{-- for_additional_stylesheet | only for this page --}}
{{--susant style sheets--}}
<style>
    .uk-radio{
        margin: 0!important;
        margin-right: 10px!important;
    }
    .uk-radio:focus{
        outline:none!important;
    }
</style>
{{-- main_content --}}
@section('content')

    @include('partials.message-success')
    @include('partials.message-error')
    
    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li> {{ $e }}</li>
                @endforeach
            </ul>

        </div>
    @endif
    <section class="content__box content__box--shadow">
        <div class="  details-of-orders">
            <span class="title">edit products</span>
            <div class="clearfix"></div>
        </div>
    </section>
    <form class="uk-form-horizontal uk-margin-large" action="{{route('vendor.products.update')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $product->id }}">
        <section class="content__box content__box--shadow">
            <div class="row">
                <div class="col-md-12">
                    <section class="add-product__form--left">
                        <div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#simple" aria-controls="simple" role="tab"
                                                                          data-toggle="tab">Basic Product Information</a></li>
                                <li role="presentation" ><a href="#category" aria-controls="simple"
                                                            role="tab"
                                                            data-toggle="tab">Select Category</a></li>
                                <li role="presentation"><a href="#pricing" aria-controls="pricing" role="tab"
                                                           data-toggle="tab">Product Attributes</a></li>
                                <li role="presentation"><a href="#images" aria-controls="pricing" role="tab"
                                                           data-toggle="tab">Images</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane " id="category">
                                    <style>
                                        ul.parent-list li:hover > ul {
                                            display: block !important;
                                        }
                                        input.product--hidden-category{
                                            border:none;
                                        }
                                        .all-menus ul li.parent {
                                            position: relative;
                                            border-bottom: 1px solid #ccc;
                                            font-size: 15px;
                                            padding: 5px 20px;
                                        }

                                        .all-menus ul > li > ul {
                                            width: 200px;
                                            position: absolute;
                                            left: 100%;
                                            top: 0;
                                            display: none;
                                            z-index: 999;
                                            padding: 0;
                                            margin: 0;
                                        }

                                        .all-menus {
                                            padding: 0 !important;
                                        }

                                        .all-menus ul.parent-list {
                                            list-style: none;
                                            margin: 0;
                                            padding: 0;
                                        }

                                        .all-menus ul > li > ul > li {
                                            font-size: 13px;
                                            padding: 5px 20px;
                                            border-bottom: 1px solid #ccc;
                                        }
                                    </style>

                                    <section>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <h3>All Menus</h3>
                                                <hr>
                                                <div class="content__box content__box--shadow all-menus">
                                                    <ul class="parent-list">
                                                        @foreach($categorys as $category)

                                                            
                                                            <li class="parent">
                                                                <a href="javasacript::void(0)" class="category-product"
                                                                   data-category="{{$category->id}}"
                                                                   data-name="{{$category->name}}">{{$category->name}}</a>
                                                                @if($category->children)
                                                                    <ul style="list-style: none;"
                                                                        class="content__box--shadow">
                                                                        @foreach($category->children as $cat)
                                                                            <li>
                                                                                <a href="javasacript::void(0)"
                                                                                   class="category-product"
                                                                                   data-category="{{$cat->id}}"
                                                                                   data-name="{{$cat->name}}">{{$cat->name}}</a>
                                                                                @if($cat->children )
                                                                                    <ul style="list-style: none;"
                                                                                        class="content__box--shadow">
                                                                                        @foreach($cat->children as $child )
                                                                                            <li>
                                                                                                <a href="javasacript::void(0)"
                                                                                                   class="category-product"
                                                                                                   data-category="{{$child->id}}"
                                                                                                   data-name="{{$child->name}}">{{$child->name}}</a>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
											<div class="col-xs-9">
                                                <h3>Your Selected Category: <span style="color: red"> <input type="text" value="{{ $product->categories ? $product->categories->first()->name : '' }}" id="category_name" class="product--hidden-category" readonly/></span></h3>
                                                

                                                <hr>
                                                <input type="hidden" value="" id="category_id" name="category" />
                                            </div>
                                        </div>
										<div class="clearfix"> </div>
                                        <div class="col-md-3">
                                            <section class="add-product__form--right">
                                                <div class=" uk-card uk-card-default uk-card-body uk-padding-small">
                                                    <div class="title">Brand</div>
                                                    <div class="simple__box">
                                                        <div class="checkbox" style="width: 100%">
                                                            <select class="js-example-basic-multiple select2" name="brand_id" style="width: 100%">
                                                                <option value="128" @if(isset($product) && $product->brand_id == 128) selected @endif>Non Brand</option>
                                                                @foreach($brands as $brand)

                                                                    <option value="{{$brand->id}}" @if($product->brand_id == $brand->id) selected @endif>{{$brand->name}}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="add_more1">
                                                        <div class="form-group add_more-category display--none ">
                                                            <input type="text" class="form-control margin__bottom">
                                                            <select class="form-control margin__bottom ">
                                                                <option value="0" selected="selected">— Parent category —</option>
                                                                <option class="level-0" value="23">Food</option>
                                                                <option class="level-1" value="27">&nbsp;&nbsp;&nbsp;sdfsdfsdf</option>
                                                                <option class="level-0" value="24">Travel</option>
                                                                <option class="level-0" value="26">Uncategorized</option>
                                                            </select>
                                                            <button type="button" class="btn btn-primary ">Add</button>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                {{-- <div class="tag__box">
                                                    <div class="title" >tags</div>
                                                    <div class="tag--input">
                                                        <input type="text" value=""  name="tags" data-role="tagsinput" class="form-control"/>
                                                        <h6 class="help-block">write tags and press ',' to add it</h6>
                                                    </div>
                                                </div> --}}
                                            </section>
                                        </div>

                                    </section>

                                    <section class="col-md-12 content__box uk-margin-top">
                                        <div class="product--info">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#inventory">inventory</a></li>
                                                <li><a data-toggle="tab" href="#specification">Specification</a></li>
                                                <li><a data-toggle="tab" href="#feature">Features</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="inventory" class="tab-pane fade in active">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">


                                                                <div class="form-group col-md-12 sale--inline">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">SKU (Stock Keeping Unit)</span>
                                                                        <input id="sku" type="text" class="form-control" name="sku"
                                                                               placeholder="Additional Info" value="{{ $product->sku }}">
                                                                    </div>
                                                                </div>
                                                               
                                                            </div>


                                                           
                                                            <div class="form-group pad-20">
                                                                <label class="col-sm-3 control-label" for="stock_availability_status">Stock
                                                                    Availability</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control" name="stock">
                                                                        <option value="1" @if($product->stock == 1) selected @endif>In Stock</option>
                                                                        <option value="0" @if($product->stock == 0) selected @endif>Out of Stock</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="specification" class="tab-pane fade">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table table-bordered table-specifications">
                                                                <thead>
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Title</th>
                                                                    <th>Description</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($product->specifications))
                                                                    @foreach($product->specifications as $specification)
                                                                        <tr data-row="{{ $loop->iteration }}">
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text"
                                                                                           name="specifications[title][{{ $specification->id }}]"
                                                                                           value="{{ $specification->title }}"
                                                                                           class="form-control" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text"
                                                                                           name="specifications[description][{{ $specification->id }}]"
                                                                                           value="{{ $specification->description }}"
                                                                                           class="form-control" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="javascript:void(0)"
                                                                                   class="btn btn-danger btn-xs btn-delete-specification" data-specification="{{ $specification->id }}"><i
                                                                                            class="fa fa-trash"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                                <tfoot>
                                                                <tr>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th>
                                                                        <button class="btn btn-danger btn-sm btn-add-specification">Add New</button>
                                                                    </th>
                                                                </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="feature" class="tab-pane fade">
                                                    <h3>Product Feature</h3>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table table-bordered table-features">
                                                                <thead>
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Features</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($product->features))
                                                                    @foreach($product->features as $feature)
                                                                        <tr data-row="{{ $loop->iteration }}">
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text"
                                                                                           name="features[feature][{{ $feature->id }}]"
                                                                                           value="{{ $feature->feature }}"
                                                                                           class="form-control" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button"
                                                                                        class="btn btn-danger btn-xs btn-delete-feature"
                                                                                        data-feature="{{ $feature->id }}"><i
                                                                                            class="fa fa-trash"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                                <tfoot>
                                                                <tr>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th>
                                                                        <button class="btn btn-danger btn-sm btn-add-feature">Add New</button>
                                                                    </th>
                                                                </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                </div>
                                <div role="tabpanel" class="tab-pane active" id="simple">
                                    <section class="simple__box">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <input type="text" class="form-control" name="name"
                                                       placeholder="Product title" value="{{ $product->name }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 sale--inline">
                                                <label class="uk-form-label" for="form-horizontal-text">Sale Price</label>
                                                <div class="uk-form-controls">
                                                    <div class="uk-inline">
                                                        <span class="uk-form-icon">Rs</span>
                                                        <input id="msg" class="uk-input" type="text" name="product_price" value="{{ $product->product_price }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 sale--inline">
                                                <label class="uk-form-label" for="form-horizontal-text">Special Price</label>
                                                <div class="uk-form-controls">
                                                    <div class="uk-inline">
                                                        <span class="uk-form-icon">Rs</span>
                                                        <input id="msg" class="uk-input" type="text" name="sale_price" value="{{ $product->sale_price }}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        

                                       
                                        <section class="description">
                                            <div class="title">long description</div>
                                            <textarea class="longdescrip" name="long_description">{{ $product->long_description }}</textarea>

                                        </section>



                                    </section>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="pricing">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <div class="form-group stock-qty pad-20" >
                                                                <label class="col-sm-3 control-label" for="qty">Stock Qty</label>
                                                                <div class="col-sm-9">
                                                                    <input min="0" class="form-control" name="stock_quantity" type="number" value="{{ $product->stock_quantity }}">
                                                                </div>
                                                            </div>
                                            <table class="table table-bordered table-colors">
                                                <thead>
                                                <tr style="background: #d8011f;color: #FFF;">
                                                    <th>SN</th>
                                                    <th>Quantity</th>
                                                    <th>Size</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(isset($product->additionals))
                                                    @foreach($product->additionals as $additional)
                                                        <tr data-row="{{ $loop->iteration }}">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="number" name="additionals[quantity][{{ $additional->id }}]"
                                                                           value="{{ $additional->quantity }}"
                                                                           class="form-control" required>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" name="additionals[size][{{ $additional->id }}]"
                                                                           value="{{ $additional->size }}"
                                                                           class="form-control" required>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger btn-xs btn-delete-color"
                                                                        data-faq="{{ $additional->id }}"><i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                                <tfoot>
                                                <tr style="color: #ccc;">
                                                    <th>Example</th>
                                                    <th>eg.2</th>
                                                    <th>eg.XL</th>
                                                    <th>
                                                        <a href="javascript:void(0)"
                                                           class="btn btn-danger btn-sm btn-add-color">Add New</a>
                                                    </th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="images">
                                    @include('merchant.product.images')
                                    
                                    <section class="content__box submit__box pull-right">
                                        <button type="submit" class="uk-button uk-button-primary">Update</button>
                                        {{--<div class="clearfix"></div>--}}
                                    </section>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
        </section>
    </form>
@endsection
{{-- for_additional_scripts | only for this page --}}
@push('scripts')

<script>
    /**
     * Generate random integer
     *
     * @returns {number}
     */
	   $(document).on("click", ".category-product", function (e) {
        e.preventDefault();
        var $this = $(this);
        document.getElementById("category_id").value = $this.attr('data-category');
        document.getElementById("category_name").value = $this.attr('data-name');

    });

    function generateRandomInteger() {
        return Math.floor(Math.random() * 90000) + 10000;
    }

    jQuery(document).on('click', '.btn-delete-specification', function (e) {
        e.preventDefault();

        var $this = $(this);

        var specification = $this.attr('data-specification');

        if (!specification) {
            $this.closest("tr").remove();
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('vendor.product.specification.delete')  }}",
            data: {
                specification: specification
            },
            beforeSend: function () {
                $this.prop('disabled', true);
            },
            success: function (data) {
                $this.closest("tr").remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //
            },
            complete: function () {
                $this.prop('disabled', false);
            }
        });
    });
    jQuery(document).on('click', '.btn-add-specification', function (e) {
        e.preventDefault();
        console.log('tgd');
        var lastRow = $('table.table-specifications > tbody > tr').last().attr('data-row');
        var counter = lastRow ? parseInt(lastRow) + 1 : 1;
        var randomInteger = generateRandomInteger();
        var newRow = jQuery('<tr data-row="' + counter + '">' +
            '<td>' + counter + '</td>' +
            '<td><input type="text" name="specifications[title][' + randomInteger + ']" class="form-control" /></td>' +
            '<td><input type="text" name="specifications[description][' + randomInteger + ']" class="form-control" /></td>' +
            '<td><button type="button" class="btn btn-danger btn-xs btn-delete-specification" data-specification=""><i class="fa fa-trash"></i></button></td>' +
            '</tr>');
        jQuery('table.table-specifications').append(newRow);
    });

    // Add feature
    /**
     * Generate random integer
     *
     * @returns {number}
     */
    function generateRandomInteger() {
        return Math.floor(Math.random() * 90000) + 10000;
    }

    jQuery(document).on('click', '.btn-delete-feature', function (e) {
        e.preventDefault();

        var $this = $(this);

        var feature = $this.attr('data-feature');

        if (!feature) {
            $this.closest("tr").remove();
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('vendor.product.feature.delete')  }}",
            data: {
                feature: feature
            },
            beforeSend: function () {
                $this.prop('disabled', true);
            },
            success: function (data) {
                $this.closest("tr").remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //
            },
            complete: function () {
                $this.prop('disabled', false);
            }
        });
    });
    jQuery(document).on('click', '.btn-add-feature', function (e) {
        e.preventDefault();
        console.log('tgd');
        var lastRow = $('table.table-features > tbody > tr').last().attr('data-row');
        var counter = lastRow ? parseInt(lastRow) + 1 : 1;
        var randomInteger = generateRandomInteger();
        var newRow = jQuery('<tr data-row="' + counter + '">' +
            '<td>' + counter + '</td>' +
            '<td><input type="text" name="features[feature][' + randomInteger + ']" class="form-control" /></td>'  +
            '<td><button type="button" class="btn btn-danger btn-xs btn-delete-feature" data-feature=""><i class="fa fa-trash"></i></button></td>' +
            '</tr>');
        jQuery('table.table-features').append(newRow);
    });


    // Add FAQS
    /**
     * Generate random integer
     *
     * @returns {number}
     */
    function generateRandomInteger() {
        return Math.floor(Math.random() * 90000) + 10000;
    }

    jQuery(document).on('click', '.btn-delete-faq', function (e) {
        e.preventDefault();

        var $this = $(this);

        var faq = $this.attr('data-faq');

        if (!faq) {
            $this.closest("tr").remove();
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('vendor.product.faq.delete')  }}",
            data: {
                faq: faq
            },
            beforeSend: function () {
                $this.prop('disabled', true);
            },
            success: function (data) {
                $this.closest("tr").remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //
            },
            complete: function () {
                $this.prop('disabled', false);
            }
        });
    });
    jQuery(document).on('click', '.btn-add-faq', function (e) {
        e.preventDefault();
        console.log('tgd');
        var lastRow = $('table.table-faqs > tbody > tr').last().attr('data-row');
        var counter = lastRow ? parseInt(lastRow) + 1 : 1;
        var randomInteger = generateRandomInteger();
        var newRow = jQuery('<tr data-row="' + counter + '">' +
            '<td>' + counter + '</td>' +
            '<td><input type="text" name="faqs[question][' + randomInteger + ']" class="form-control" required/></td>' +
            '<td><input type="text" name="faqs[answer][' + randomInteger + ']" class="form-control" required/></td>' +
            '<td><button type="button" class="btn btn-danger btn-xs btn-delete-faq" data-faq=""><i class="fa fa-trash"></i></button></td>' +
            '</tr>');
        jQuery('table.table-faqs').append(newRow);
    });

    // Add Size
    /**
     * Generate random integer
     *
     * @returns {number}
     */
    function generateRandomInteger() {
        return Math.floor(Math.random() * 90000) + 10000;
    }

    // Add color
    /**
     * Generate random integer
     *
     * @returns {number}
     */
    function generateRandomInteger() {
        return Math.floor(Math.random() * 90000) + 10000;
    }

    jQuery(document).on('click', '.btn-delete-color', function (e) {
        e.preventDefault();

        var $this = $(this);

        var color = $this.attr('data-color');

        if (!color) {
            $this.closest("tr").remove();
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('vendor.product.color.delete')  }}",
            data: {
                color: color
            },
            beforeSend: function () {
                $this.prop('disabled', true);
            },
            success: function (data) {
                $this.closest("tr").remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //
            },
            complete: function () {
                $this.prop('disabled', false);
            }
        });
    });
    jQuery(document).on('click', '.btn-add-color', function (e) {
        e.preventDefault();
        console.log('tgd');
        var lastRow = $('table.table-colors > tbody > tr').last().attr('data-row');
        var counter = lastRow ? parseInt(lastRow) + 1 : 1;
        var randomInteger = generateRandomInteger();
        var newRow = jQuery('<tr data-row="' + counter + '">' +
            '<td>' + counter + '</td>' +
            '<td><input type="number" name="additionals[quantity][' + randomInteger + ']" class="form-control" required row="2"/></td>'  +
            '<td><input type="text" name="additionals[size][' + randomInteger + ']" class="form-control" required/></td>'  +
            '<td><button type="button" class="btn btn-danger btn-xs btn-delete-color" data-color=""><i class="fa fa-trash"></i></button></td>' +
            '</tr>');
        jQuery('table.table-colors').append(newRow);
    });


    jQuery(document).on('click', '.product-image-list .is_main_image_button', function (e) {
        e.preventDefault();

        jQuery('.product-image-list .is_main_image_button').removeClass('active');
        jQuery('.product-image-list .is_main_image_hidden_field').val(0);


        if (jQuery(this).hasClass('active')) {

            jQuery(this).removeClass('active');
            jQuery(this).parents('.image-preview:first').find('.is_main_image_hidden_field').val(0);
        } else {
            jQuery(this).addClass('active');
            jQuery(this).parents('.image-preview:first').find('.is_main_image_hidden_field').val(1);
        }

    });

    jQuery(document).on('click', '.product-image-list .image-preview .destroy-image', function (e) {

        var token = jQuery('.product-image-element').attr('data-token');
        var path = jQuery(e.target).parents('.image-preview:first').find('.img-tag').attr('data-path');
        var data = {_token: token, path: path};
        jQuery.ajax({
            url: '{{ url('vendors/product/image/delete') }}',
            data: data,
            dataType: 'json',
            type: 'post',
            success: function (response) {
                if (response.success === true) {
                    jQuery(e.target).parents('.image-preview:first').remove();
                }

            }
        });

    });

    jQuery('.product-image-element').change(function (e) {
        var files = e.target.files;

        var imagewidth = $(".product-image-element")[0].files[0].size;
        
        
        if (imagewidth > 2070382) {
            
            sweetAlert('', 'Your Image Size is More than 2MB.'); 
            jQuery(".product-image-element").val('');

        }else{
          var formData = new FormData();

        formData.append('_token', jQuery(e.target).attr('data-token'));
        for (var i = 0, file; file = files[i]; ++i) {
            formData.append('image', file);
        }
        var myUrl = "{{ url('/vendors/product/image/upload') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: myUrl,
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function (data) {
            $('#image-progress').fadeIn(100);

            },
            success: function (data) {
                jQuery('.product-image-list').append(data);
                if (jQuery('.product-image-list .image-preview').length === 1) {
                    jQuery('.product-image-list .image-preview .is_main_image_button').trigger('click');
                }

                jQuery(".product-image-element").val('');

                $('#image-progress').fadeOut(100);
            },
            error: function (err) {

                $('#image-progress').fadeOut(100);
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span style="color: red;">' + error[0] + '</span>').fadeOut(15000));
                    });
                }
            }
        });  
            
        }

        

        {{--var xhr = new XMLHttpRequest();--}}
        {{--xhr.open('POST', '{{ url('/vendors/product/image/upload') }}', true);--}}
        {{--xhr.onload = function (e) {--}}
            {{--if (this.status === 200) {--}}
                {{--jQuery('.product-image-list').append(this.response);--}}
                {{--if (jQuery('.product-image-list .image-preview').length === 1) {--}}
                    {{--jQuery('.product-image-list .image-preview .is_main_image_button').trigger('click');--}}
                {{--}--}}
            {{--}--}}
        {{--};--}}

        {{--xhr.send(formData);--}}

        {{--jQuery(".product-image-element").val('');--}}
    });
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endpush