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
<div class="image-preview">
    <div class="actual-image-thumbnail">
        <img class="img-thumbnail img-tag img-responsive" src="{{ $image->smallUrl }}"
             data-path="{{ $image->relativePath }}"/>
        <input type="hidden" name="image[{{ $tmp }}][path]" value="{{ $image->relativePath }}"/>
        <input type="hidden" class="is_main_image_hidden_field" name="image[{{ $tmp }}][is_main_image]" value="0"/>

    </div>
    <div class="image-info">
        <div class="image-title">
            XYZ.jpg
        </div>
        <div class="actions">
            <div class="action-buttons">

                <button type="button"
                        class="btn btn-xs btn-info is_main_image_button  selected-icon"
                        title="Select as main image">
                    <i class="fa fa-check"></i>
                </button>
                <button type="button" class="btn btn-xs btn-danger destroy-image" title="Remove file">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    </div>

</div>