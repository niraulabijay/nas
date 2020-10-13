@extends('merchant.layouts.app')
@section('title',"Negotiable")
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

    <div class="wishlist__container tabcontent " id="negotiable">
        <h3>Negotiable</h3>
        <div class="table-responsive hidden-xs">
            <table class="table table-bordered" id="negotiableTable">
                <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Name</th>
                    <th>Sales Price</th>
                    <th>Negotiable Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($nego_topic as $nego_product)
                    <tr>
                        <td>
                            <div>
                                <a href="">
                                    <img src="{{$nego_product->product->getImageAttribute()->smallUrl}}"
                                         alt="" style="width:100px">
                                </a>
                            </div>
                        </td>
                        <td>
                            <span class="price">{{$nego_product->product->name}}</span>
                        </td>
                        <td>
                            <span class="price">{{$nego_product->product->sale_price}}</span>
                        </td>
                        <td>
										@if($nego_product->fixed_price == null)
                                    <span class="price" style="color: #ccc">
												yet not fixed
											</span>
                                @else
                                    <span>
                                                  {{ $nego_product->fixed_price }}
                                                </span>
                                @endif
                        </td>

                       


                        <td>
                            <a class="btn btn-default btnMenu request" href="{{ route('vendor.negotiate.vendor',$nego_product->id) }}">Negotiate</a>

{{--                            <a class="btn btn-default btnMenu request" href="{{ route('negotiate.delete',$nego_product->id) }}">Remove</a>--}}
                        </td>
                    </tr>
                @endforeach
                {{ $nego_topic->links() }}

                <div id="negotiable_chat" class="modal fade in" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel" style="display: none; padding-left: 0px;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="display: block;">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Sassung Mobile</h4>

                                <div class="row col-xs-12>
														<div class=" content__box content__box--shadow
                                " id="chatBox" style="height:350px;overflow: auto;">
                                <div id="reload-admin">

                                </div>

                            </div>

                        </div>
                    </div>


                </div>
        </tbody>
        </table>

    </div>
    </div>


@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#negotiableTable').DataTable();
    });
</script>
@endpush