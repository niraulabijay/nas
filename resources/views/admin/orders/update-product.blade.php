<td class="thumb" width="2%">
    <div class="thumbnail mb-none">
        <img src="{{ getProductImage($product->id, 'smallUrl') }}"
             class="img-responsive" alt="" title="">
    </div>
</td>
<td class="name" width="7%">
    <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
</td>
<td class="merchant" width="2%">
    <span>{{ isset(\App\Model\Vendor::where('user_id',$product->user_id)->first()->name) ? \App\Model\Vendor::where('user_id',$product->user_id)->first()->name : 'N/A' }}</span>
</td>
<td class="color" width="1%">
    <span>{{ isset($product->additionals->first()->color) ? $product->additionals->first()->color : 'N/A' }}</span>
</td>
<td class="size" width="1%">
    <span>{{ isset($product->additionals->first()->size) ? $product->additionals->first()->size : 'N/A'  }}</span>
</td>
<td class="item_cost" width="1%">
    <span>Rs{{ $product->price }}</span>
    <input type="hidden" name="price" value="{{ $product->price }}">
</td>
<td class="quantity" width="1%">
    <div class="view">
        <input type="number" name="quantity" value="{{ $product->quantity }}" min="1" class="form-control">
    </div>
</td>
<td class="discount" width="2%">
    <div class="view">
        <input type="number" name="discount" value="{{ $product->discount }}" min="0" class="form-control">
    </div>
</td>
<td class="tax" width="2%">
    <div class="view">
        <input type="number" name="tax" value="{{ $product->tax }}" min="0" class="form-control">
    </div>
</td>
<td class="line_cost" width="1%">
    <div class="view">
        Rs {{ number_format($product->price_total, 2) }}
    </div>
</td>
<td class="order-actions" width="3%">
    <button type="button" class="btn btn-sm btn-info update-order-item">
        Update
    </button>
    <button type="button" class="btn btn-sm btn-danger delete-order-item">
        <span class="lnr lnr-trash"></span>
    </button>
</td>