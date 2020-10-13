@extends('layouts.app')
@section('title', 'MarketPlace')
@section('content')
<div class="container">
    <div class="inner style__product-comparision">

        <div class="Content" id="LayoutColumn1">

            <h2 class="TitleHeading">Product Comparison</h2>
            <div class="fullwidth">
                <div class="block " id="CompareContent">
                    <h4 class="bold">Product Comparison: {{ $first->name }} VS {{ $second->name }}</h4>
                    <div class="blockcontent">
                        <div class="alert alert-info InfoMessage">
                            Your product comparison is shown below. Click a product attribute in the left column to sort by that attribute.
                            <button type="button" class="close alert--close"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <p class="ErrorMessage" style="display: none"></p>
                        <table cellspacing="0" cellpadding="0" class="table comparisonTable">

                            <thead>
                                <tr class="active">
                                    <th class="comparefield--top" width="20%" style="text-align: left; font-weight: bold;">Product Details</th>
                                    <th class="comparefield--top" id="compare_1_0" >
                                        Product 1
                                    </th>
                                    <th class="comparefield--top" id="compare_1_1" >
                                        Product 2
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td class="comparefield--name">
                                    Product
                                </td>
                                <td class="compare-col" id="compare_2_0">
                                    <a href="{{route('product.show',$first->slug)}}">{{ $first->name }}</a>
                                </td>
                                <td class="compare-col" id="compare_2_1">
                                    <a href="{{route('product.show',$second->slug)}}">{{ $second->name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="comparefield--name">Image</td>
                                <td class="compare-col" id="compare_3_0">
                                    <a href="{{route('product.show',$first->slug)}}">
                                        <img src="{{ $first->getImageAttribute()->mediumUrl }}" alt="{{ $first->name }}"></a>
                                </td>
                                <td class="compare-col" id="compare_3_1">
                                    <a href="{{route('product.show',$second->slug)}}">
                                        <img src="{{ $second->getImageAttribute()->mediumUrl }}" alt="{{ $second->name }}"></a>
                                </td>

                            </tr>
                            <tr style="">
                                <td class="comparefield--name">
                                    Price
                                </td>
                                <td class="compare-col" id="compare_4_0">
                                    <span class="compare--price">Rs.{{ $first->sale_price }}</span>
                                </td>
                                <td class="compare-col" id="compare_4_1">
                                    <span class="compare--price">Rs. {{ $second->sale_price }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="comparefield--name">
                                    Brand
                                </td>
                                <td class="compare-col" id="compare_10_0">{{ $first->brand->name ? $first->brand->name : 'N/A' }}</td>
                                <td class="compare-col" id="compare_10_1">{{ $second->brand->name ? $second->brand->name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="comparefield--name">Availability</td>
                                <td class="compare-col" id="compare_5_0">{{ $first->stock_quantity ? $first->stock_quantity : 'N/A' }}</td>
                                <td class="compare-col" id="compare_5_1">{{ $second->stock_quantity ? $second->stock_quantity : 'N/A' }}</td>
                            </tr>
                            <tr style="">
                                <td class="comparefield--name">
                                    Rating
                                </td>
                                <td class="compare-col CompareRating" id="compare_6_0">
                                    <span class="Rating Rating3">
                                        <img src="http://cdn6.bigcommerce.com/r-483c7abee042f74241e481d69b7951a17734ea93/themes/ClassicNext/images/IcoRating3.png" alt="" style="">
                                    </span>
                                    <span style="">[{{ $first->getAverageRating() }}]<br>
                                        <a href="#">Read Reviews</a>
                                    </span>
                                </td>
                                <td class="compare-col CompareRating" id="compare_6_1">
                                    <span class="Rating Rating2">
                                        <img src="http://cdn6.bigcommerce.com/r-483c7abee042f74241e481d69b7951a17734ea93/themes/ClassicNext/images/IcoRating2.png" alt="" style="">
                                    </span>
                                    <span style="">[{{ $second->getAverageRating() }}]<br>
                                        <a href="#">Read Reviews</a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="comparefield--name">Summary</td>
                                <td class="compare-col" id="compare_7_0">{{ $first->long_description ? strip_tags($first->long_description) : 'N/A' }}</td>
                                <td class="compare-col" id="compare_7_1">{{ $second->long_description ? strip_tags($second->long_description) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="comparefield--name">Other</td>
                                <td class="compare-col" id="compare_9_0">
                                    <strong>Size:</strong><br>
                                    @if($first->additionals->isNotEmpty())
                                    @foreach($first->additionals as $product)
                                        {{ $product->size ? $product->size : 'N/A' }},
                                    @endforeach
                                    @else
                                        N/A
                                    @endif
                                    <br>
                                </td>
                                <td class="compare-col" id="compare_9_1">
                                    <strong>Size:</strong><br>
                                    @if($second->additionals->isNotEmpty())
                                    @foreach($second->additionals as $product)
                                        {{ $product->size ? $product->size : 'N/A' }},
                                    @endforeach
                                    @else
                                        N/A
                                    @endif
                                    <br>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
@endsection