@extends('admin.layouts.app')
@section('title', 'Create Order')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/">Order</a></li>
            <li class="active">Create</li>
        </ol>
        <h1>Add New Order</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            {!! Form::open(['route'=>'admin.order.store', 'files' => true, 'class' => 'form-order']) !!}
            @include('admin.orders.form', ['submitButtonText' => 'Submit'])
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
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

                var shipping_amount = $("select[name=shipping_amount]").find(":selected").val();
                if(shipping_amount)
                {
                    shipping_amount = shipping_amount;
                }
                else
                {
                    shipping_amount = 0;
                }

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
                    products: productsArray
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
            format: "yyyy/mm/dd",
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
                        tax:tax
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
            var shipping_amount = $("select[name=shipping_amount]").find(":selected").val();

            // Address details
            var firstName = $("input[name=first_name]").val();
            var lastName = $("input[name=last_name]").val();
            var email = $("input[name=email]").val();
            var mobile = $("input[name=mobile]").val();
            var phone = $("input[name=phone]").val();
            var area = $("input[name=area]").val();
            var district = $("input[name=district]").val();
            var zone = $("input[name=zone]").val();

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
                    tax: tax,
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
                    url: "{{ route('admin.order.store')  }}",
                    data: {
                        order_date: orderDate,
                        order_status: orderStatus,
                        customer: customer,
                        order_note: orderNote,
                        shipping_amount: shipping_amount,
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        mobile: mobile,
                        phone: phone,
                        area: area,
                        district: district,
                        zone: zone,
                        products: products,
                    },
                    beforeSend: function (data) {
                        $this.button('loading');
                    },
                    success: function (data) {
                        if (data.success) {
                            $this.prop('disabled', true);
                            $('.alert.alert-danger').fadeOut();
                            $('.alert.alert-success').fadeIn().html(data.message);
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

                        $('.alert.alert-danger').fadeIn().html(errorsHolder);
                    },
                    complete: function () {
                        $("form")[0].reset(),
                        $this.button('reset');
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                });
            } else {
                alert('Select products to continue.');
            }

        });

    </script>
@endpush