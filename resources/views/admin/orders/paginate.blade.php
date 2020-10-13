@isset($ordersArray)
@foreach($ordersArray as $order)
    <tr>
        <td style="position: relative"><div><span style=" position: absolute; bottom: 3px; left: 4px; ">{{ $loop->iteration }}</span> <input style="display: inline-block" type="checkbox" name="orders" class="order" value="{{ $order['id'] }}"></div></td>
        <td>{{ $order['order_no']}}</td>
        <td><span class="label label-{{ getOrderStatusClass($order['order_status']) }}">{{ $order['order_status'] }}</span></td>
        <td><ul class="no-margin no-padding no-list-style" style="list-style: none;">
                <li><a href=""># {{ $order['userOrder']['order_id'] }} </a>
                    by
                    <a href="">{{ $order['address']['address_first_name'] }} {{ $order['address']['address_last_name'] }} </a>
                </li>
                <li>
                    <a href="mailto:{{ $order['userOrder']['user_email'] }}"> {{ $order['userOrder']['user_email'] }}</a></li>
            </ul>
        </td>
        <td><ul class="no-margin no-padding no-list-style" style="list-style: none;">
            @isset($order['products'])
               @foreach($order['products'] as $product)
                    <li><a href="#"><label class="label label-default">1</label> {{ $product['name'] }}</a>
                    </li>
                   @endforeach
                   @endisset
                <a href="{{ route('admin.order.invoice',  $order['id']) }}" class="btn btn-xs btn-default mr-5" target="_blank">Invoice</a>
            </ul>
        </td>
        <td>{{ $order['payment'] }}</td>
        <td>
            <ul class="no-margin no-padding no-list-style" style="list-style: none;">
                <li><a href="">{{ $order['address']['address_first_name'] }} {{ $order['address']['address_last_name'] }} </a>
                    by
                    <a href="">{{ $order['address']['address_area'] }}  </a>
                </li>
                <li>
                    <a href=""> {{ $order['address']['address_district'] }}, {{ $order['address']['address_zone'] }}</a></li>
            </ul>
        </td>
        <td>{{ $order['order_date'] }}</td>
        <td>Rs. {{ $order['price_total'] }}</td>
        <td>
            <a href="{{ route('admin.order.edit', $order['id']) }}" class="btn btn-xs btn-info mr-5"><span class="lnr lnr-pencil"></span></a>
            <form action="{{ route('admin.order.destroy',  $order['id']) }}" method="post" style="display: inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-xs btn-danger btn-delete"><span class="lnr lnr-trash"></span></button>
            </form>
            <a href="{{ route('admin.order.invoice',  $order['id']) }}" class="btn btn-xs btn-default mr-5" target="_blank">Invoice</a>
            <a href="{{ route('admin.order.barcode',  $order['id']) }}" class="btn btn-xs btn-default mr-5" target="_blank">Print Barcode</a></td>
    </tr>
@endforeach
<tr>
    <td colspan="12" align="center" class="hidden-privent">
        {!! $orders->links() !!}
    </td>
</tr>



@endisset