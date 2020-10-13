<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export</title>
</head>
<body>
<table>
    <tr>
        <th>
            name
        </th>
        <th>
            Product Proce
        </th>
        <th>
            Product Sale Price
        </th>
        <th>
            Stock Quantity
        </th>
        <th>
            Long Description
        </th>
        <th>
            Short Description
        </th>
    </tr>
    @foreach($product as $c)
        <tr>
            <td>
                {{ $c->product_name }}
            </td>
            <td>
                {{ $c->product_price }}
            </td>
            <td>
                {{ $c->sale_price }}
            </td>
            <td>
                {{ $c->stock_quantity }}
            </td>
            <td>
                {{ $c->answer }}
            </td>
            <td>
                {{ $c->long_description }}
            </td>
            <td>
                {{ $c->short_description }}
            </td>
        </tr>

    @endforeach
    {{--<a href="{{route('products.export')}}">Export</a>--}}
</table>
</body>
</html>