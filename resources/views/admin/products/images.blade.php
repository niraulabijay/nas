<style>
    .image-preview {
        position: relative;
        display: table;
        margin: 0 15px 15px 0;
        border: 1px solid #ddd;
        box-shadow: 1px 1px 5px 0 #a2958a;
        padding: 6px;
        float: left;
        text-align: center;
    }
    .image-preview .actual-image-thumbnail {
        height: 170px;
    }
    .image-preview .image-info {
        position: relative;
        height: 70px;
    }
    .image-preview .image-info .active.selected-icon {
        background-color: #f39c12;
        border-color: #e08e0b;
    }
</style>
{!! Form::file('file',['class' => 'product-image-element form-control','data-token' => csrf_token()]) !!}

<div class="product-image-list">

    @if(isset($product) && count($product->images()->get()) > 0)
        @foreach($product->images()->get() as $image)
            <?php $class = ( $image->is_main_image == 1 ) ? "active" : ""; ?>
            <div class="image-preview">
                <div class="actual-image-thumbnail">
                    <img class="img-thumbnail img-tag img-responsive" src="{{ ($image->path->smallUrl) }}"
                         data-path="{{ $image->path->relativePath }}"/>
                    <input type="hidden" name="image[{{ $image->id }}][path]" value="{{ $image->path->relativePath }}"/>
                    @if($image->is_main_image)
                        <input type="hidden" class="is_main_image_hidden_field"
                               name="image[{{ $image->id }}][is_main_image]" value="1"/>
                    @else
                        <input type="hidden" class="is_main_image_hidden_field"
                               name="image[{{ $image->id }}][is_main_image]" value="0"/>
                    @endif
                </div>
                <div class="image-info">
                    <div class="image-title">
                        <a href="javascript:void(0);" title="{{ basename($image->path->relativePath) }}">
                            {{ str_limit(basename($image->path->relativePath), 20) }}
                        </a>
                    </div>
                    <div class="actions">
                        <div class="action-buttons">
                            <button type="button"
                                    class="btn btn-xs btn-info is_main_image_button {{ $class }} selected-icon"
                                    title="Select as main image">
                                <i class="fa fa-check"></i>
                            </button>
                            <button type="button"
                                    class="destroy-image btn btn-xs btn-danger"
                                    title="Remove file">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
