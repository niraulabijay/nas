
    @foreach($products as $product)

        @include('front.category.product',['product' => $product])
    @endforeach


