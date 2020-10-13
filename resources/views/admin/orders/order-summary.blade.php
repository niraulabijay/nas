@if($priceTotal != 0.00)
    <tr>
        <td colspan="5" class="">Tax Amount:</td>
        <td class="tax pull-right">
        <span class="price-amount">
            <span class="price-currency-symbol">RS </span>{{ number_format($taxAmount, 2) }}
        </span>
        </td>
    </tr>
    <tr>
        <td colspan="5" class="">Shipping Amount:</td>
        <td class="shipping_amount pull-right">
        <span class="price-amount">
            <span class="price-currency-symbol">RS </span>{{ number_format($shipping_amount, 2) }}
        </span>
        </td>
    </tr>
    <tr>
        <td colspan="5" class="">Order Total:</td>
        <td class="total pull-right">
        <span class="price-amount">
            <span class="price-currency-symbol">RS </span>{{ number_format($priceTotal, 2) }}
        </span>
        </td>
    </tr>
@endif