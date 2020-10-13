<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
        <h3 class="box-title">All Pre Bookings Orders <small>({{ $prebookings->count() }})</small></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Purchased</th>
                    <th>Payment Status</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Total</th>
                    @role('admin', 'manager', 'editor')
                    <th class="sorting-false">Action</th>
                    @endrole
                </tr>
                </thead>
                <tbody>
                    @foreach($prebookings as $preorder)
                    @php
                        $discountAmount_ = 0;
                        $productSubTotal_ = 0;
                        $taxAmount_ = 0;
                    @endphp
                    <tr>
                        <td><a href="{{ route('admin.order.edit', $preorder->id) }}">{{ $preorder->code }}</a></td>
                        <td>
                            @php
                                $statusClass = '';
                                switch ($preorder->orderStatus->name) {
                                    case 'pending':
                                        $statusClass = "warning";
                                        break;
                                    case 'approved':
                                        $statusClass = "primary";
                                        break;
                                    case 'delivered':
                                        $statusClass = "success";
                                        break;
                                    case 'received':
                                        $statusClass = "info";
                                        break;
                                    case 'cancelled':
                                        $statusClass = "danger";
                                        break;
                                    case 'review':
                                        $statusClass = "info";
                                        break;
                                    default:
                                        $statusClass = "info";
                                }
                            @endphp
                            <span class="label label-{{ $statusClass }}">{{ $preorder->orderStatus->name }}</span></td>
                        <td>
                            <a href="{{ route('admin.order.edit', $preorder->id) }}">#{{ $preorder->id }}</a> by 
                            <a href="{{ route('admin.order.edit', $preorder->id) }}">{{ $preorder->user->user_name }}</a>
                            <a href="mailto:{{ $preorder->user->email }}">{{ $preorder->user->email }}</a>
                        </td>
                        <td>
                            @foreach($preorder->orderProduct as $orderProduct)
                            @php
                                $discount = $orderProduct->discount;
                                $tax = $orderProduct->tax;
                                $actualPrice = $orderProduct->price * $orderProduct->qty;
                                $taxAmount = (($actualPrice * $tax) / 100);
                                $taxAmount_ += $taxAmount;
                                $actualPrice_ = $actualPrice + $taxAmount;
                                $discountAmount = $discount;
                                $discountAmount_ += $discountAmount;
                                $productSubTotal = $actualPrice_ - ( $discountAmount );
                                $productSubTotal_ += $actualPrice;
                            @endphp
                            <a href="#"><label class="label label-default">{{ $orderProduct->qty }}</label>{{ $orderProduct->products->name }}</a>
                            @endforeach
                            @php
                                $grandTotal = $productSubTotal_ + $taxAmount_ - $discountAmount_ + $preorder->shipping_amount;
                            @endphp
                        </td>
                        <td>{{ $preorder->payment->name }}</td>
                        <td>
                            <a href="{{ route('admin.order.edit', $preorder->id) }}">
                                {{ $preorder->shipping_address->first_name . ' ' . $preorder->shipping_address->last_name }}<br>
                                {{ $preorder->shipping_address->area }}<br>
                                {{ $preorder->shipping_address->district }}<br>
                                {{ $preorder->shipping_address->zone }}<br>
                            </a>
                        </td>
                        <td>{{ $preorder->order_date->format('d/m/Y') }}</td>
                        <td>Rs.{{ $preorder->prebookings->price }} + Rs.{{ $preorder->prebookings->products->sale_price - $preorder->prebookings->price }}
                            = Rs.{{ $grandTotal }}
                        </td>
                        <td>
                            <a href="{{ route('admin.order.edit', $preorder->id) }}" class="btn btn-info btn-xs mr-5"><span class="lnr lnr-pencil"></span></a>
                            <form action="{{ route('admin.order.destroy', $preorder->id) }}" method="post" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-xs btn-delete mr-5"><span class='lnr lnr-trash'></span></button>
                            </form>
                            <a href="{{ route('admin.order.pre_invoice', $preorder->id) }}" target="_blank" class="btn btn-default btn-xs mr-5">Pre Invoice</a><br>
                            <a href="{{ route('admin.order.invoice', $preorder->id) }}" target="_blank" class="btn btn-default btn-xs mr-5">Invoice</a>
                            <a href="{{ route('admin.order.barcode', $preorder->id) }}" target="_blank" class="btn btn-default btn-xs mr-5">Print Barcode</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Order No.</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Purchased</th>
                    <th>Payment Status</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Total</th>
                    @role('admin', 'manager', 'editor')
                    <th class="sorting-false">Action</th>
                    @endrole
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->