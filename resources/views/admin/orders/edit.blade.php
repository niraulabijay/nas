@extends('admin.layouts.app')
@section('title', 'Edit Order')
@section('content')
<style>
    .callout {
        border-radius: 3px;
        margin: 0 0 20px 0;
        padding: 15px 30px 15px 15px;
        border-left: 5px solid #eee;
    }
    .callout.callout-success {
        background-color: #00a65a !important;
        color: #fff !important;
        border-color: #00733e;
        display: none;
    }
    .callout.callout-danger {
        background-color: #dd4b39 !important;
        color: #fff !important;
        border-color: #c23321;
        display: none;
        padding-bottom: 1px;
    }
     li span {
        color: #333 !important;
        font-size: 18px !important;
    }
</style>

    <div class="callout callout-danger mb-15"></div>
    <div class="callout callout-success mb-15"></div>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/">Order</a></li>
            <li class="active">Update</li>
        </ol>
        <h1>Edit Order</h1>
        <a href="{{ url()->previous() }}" class="btn btn-default pull-right" title="Return Back" style="margin-bottom:10px;"> Return Back
                </a>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            {!! Form::model($order, ['method' => 'PATCH', 'action' => ['Backend\OrderController@update', $order->id], 'class' => 'form-order']) !!}
            @include('admin.orders.form', ['submitButtonText' => 'Update'])
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
    </section>
    
        <section>
        <div class="box content__box content__box--shadow">
            <div class="box-header with-border">
                <h3 class="box-title">User Privious Order Info</h3>
            </div>
            <div class="box-body">
                @foreach($userPreviousOrders as $previousOrder)
                @isset($previousOrder->products)
                <li style="text-align: left; color: red; font-size: 20px; margin-bottom: 10px;"><span>Product : </span>{{ $previousOrder->products->name }} <span>Date: </span> {{ $previousOrder->created_at->diffForHumans() }}<span>, Order Status : </span>{{ $previousOrder->order->orderStatus->name }}</li>
                @endisset
               @endforeach
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>

        function getOrderSummary() {
            var productsArray = [];

            $('.table-order > tbody > tr.item').each(function (i, el) {
                var product = $(el).attr('data-product');
                var price = $(el).find('.item_cost input').val();
                var quantity = $(el).find('.quantity input').val();
                var discount = $(el).find('.discount input').val();
                var tax = $(el).find('.tax input').val();

                var shipping_amount = "{{ $order->shipping_amount }}";

                productsArray.push({
                    id: product,
                    price: price,
                    quantity: quantity,
                    discount: discount,
                    tax:tax,
                    shipping_amount: shipping_amount,
                });

            });

            $.ajax({
                type: "GET",
                url: "{{ route('admin.order.update-product-summary') }}",
                data: {
                    products: productsArray,
                    order: "{{ $order->id }}"
                },
                success: function (data) {
                    $('.table-order-summary tbody').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                },
                complete: function () {
                    //
                }
            });
        }

        //Date picker
        $('#order_date').datepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            useCurrent: true
        });

        $('.select2').select2();

        $('#customer').select2({
            placeholder: 'Guest',
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('admin.search.user') }}",
                dataType: 'json',
                type: 'GET',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    return {
                        results: data
                    };
                },
                cache: true
            }

        }).on('change', function () {
            var user = this.value;

            $.ajax({
                type: "GET",
                url: "{{ route('admin.order.update-user-address') }}",
                data: {user: user},
                beforeSend: function (xhr, settings) {
                    //
                },
                success: function (data) {
                    $('div.address-details').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                },
                complete: function () {
                    //
                }
            });

        });

        $('#products').select2({
            placeholder: 'Select Product',
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('admin.search.product') }}",
                dataType: 'json',
                type: 'GET',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    return {
                        results: data
                    };
                },
                cache: true
            }

        });

        $(document).on("click", "#btn-product-add", function () {
            var $this = $(this);

            var productsSelector = $("#products");
            var products = $.trim(productsSelector.select2("val"));

            if (products) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.order.add.product') }}",
                    data: {products: products},
                    beforeSend: function (xhr, settings) {
                        $this.prop('disabled', true);
                    },
                    success: function (data) {
                        $('.table-order tbody').append(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                    },
                    complete: function () {
                        $this.prop('disabled', false);
                        productsSelector.val('').trigger('change');
                        getOrderSummary();
                    }
                });
            }
        });

        $(document).on("click", ".delete-order-item", function () {
            var $this = $(this);

            $this.parent().parent().remove();
            getOrderSummary();

        });

        $(document).on("click", ".update-order-item", function () {
            var $this = $(this);

            var productSelector = $this.parent().parent();
            var product = productSelector.attr('data-product');
            var quantity = $this.parent().parent().find('.quantity input').val();
            var discount = $this.parent().parent().find('.discount input').val();
            var tax = $this.parent().parent().find('.tax input').val();

            if (product) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.order.update-product') }}",
                    data: {
                        product: product,
                        quantity: quantity,
                        discount: discount,
                        tax: tax
                    },
                    success: function (data) {
                        productSelector.html(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                    },
                    complete: function () {
                        getOrderSummary();
                    }
                });
            }

        });

        $(document).on("click", "#btn-order-save", function (e) {
            e.preventDefault();
            var $this = $(this);

            // General details
            var orderDate = $("input[name=order_date]").val();
            var orderStatus = $("select[name=order_status]").find(":selected").val();
            var customer = $("select[name=customer]").find(":selected").val();
            var orderNote = $("textarea[name=order_note]").val();
            var shipping_amount = "{{ $order->shipping_amount }}";
            var tracking = $("textarea[name=tracking]").val();
            var delivery_destination = $("select[name=delivery_destination").find(":selected").val();
            // Address details
            var firstName = $("input[name=first_name]").val();
            var lastName = $("input[name=last_name]").val();
            var email = $("input[name=email]").val();
            var mobile = $("input[name=mobile]").val();
            var phone = $("input[name=phone]").val();
            var area = $("input[name=area]").val();
            var district = $("input[name=district]").val();
            var zone = $("input[name=zone]").val();

            var user = "{{ $userDetails->user_id }}";

            // Product details
            var products = [];

            $('.table-order > tbody > tr.item').each(function (i, el) {
                var product = $(el).attr('data-product');
                var price = $(el).find('.item_cost input').val();
                var quantity = $(el).find('.quantity input').val();
                var discount = $(el).find('.discount input').val();
                var tax = $(el).find(".tax input[name=tax]").val();

                products.push({
                    id: product,
                    price: price,
                    qty: quantity,
                    discount: discount,
                    tax: tax
                });

            });



            if (products.length > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.order.update', $order->id)  }}",
                    data: {
                        _method: 'PATCH',
                        order_date: orderDate,
                        order_status: orderStatus,
                        customer: customer,
                        order_note: orderNote,
                        shipping_amount: shipping_amount,
                        address_id: "{{ $userDetails->id }}",
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        mobile: mobile,
                        phone: phone,
                        area: area,
                        district: district,
                        zone: zone,
                        products: products,
                        tracking:tracking,
                        delivery_destination: delivery_destination
                    },
                    beforeSend: function (data) {
                        $this.button('loading');
                    },
                    success: function (data) {
                        if (data.success) {
                            $this.prop('disabled', true);
                            $('.callout.callout-danger').fadeOut();
                            $('.callout.callout-success').fadeIn().html(data.message);
                        }

                        window.setTimeout(function () {
                            location.reload()
                        }, 2000);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorsHolder = '';
                        errorsHolder += '<ul>';

                        var err = eval("(" + xhr.responseText + ")");
                        $.each(err.errors, function (key, value) {
                            errorsHolder += '<li>' + value + '</li>';
                        });

                        errorsHolder += '</ul>';

                        $('.callout.callout-danger').fadeIn().html(errorsHolder);
                    },
                    complete: function () {
                        $this.button('reset');
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                });
            } else {
                alert('Select products to continue.');
            }

        });

        getOrderSummary();


    </script>
@endpush