{{-- <div class="col-xs-12" >--}}
    <div class="col-sm-12">
        <h4>Home Products Section 1 </h4>
    </div>

    <div class="form-group">
        <label for="home_products_section1" class="col-sm-2 control-label">Select Options</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
                {!! Form::select('products_section_1', $categories, $selectedCategories_1, ['class' => 'form-control full-width select2']) !!}
            </div>
        </div>
        <label for="home_products_section1" class="col-sm-2 control-label">Deals Date</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
				{!! Form::text('deals_date', $deals_date, ['class' => 'form-control full-width']) !!}
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <h4>Home Products Section 2 </h4>
    </div>

    <div class="form-group">
        <label for="home_products-section1" class="col-sm-2 control-label">Select Options</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
                {!! Form::select('products_section_2', $categories, $selectedCategories_2, ['class' => 'form-control full-width select2']) !!}
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <h4>Home Products Section 3 </h4>
    </div>

    <div class="form-group">
        <label for="home_products-section3" class="col-sm-2 control-label">Select Options</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
                {!! Form::select('products_section_3', $categories, $selectedCategories_3, ['class' => 'form-control full-width select2']) !!}
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <h4>Home Products Section 4 </h4>
    </div>

    <div class="form-group">
        <label for="home_products-section4" class="col-sm-2 control-label">Select Options</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
                {!! Form::select('products_section_4', $categories, $selectedCategories_4, ['class' => 'form-control full-width select2']) !!}
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <h4>Home Products Section 5 </h4>
    </div>

    <div class="form-group">
        <label for="home_products-section5" class="col-sm-2 control-label">Select Options</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
                {!! Form::select('products_section_5', $categories, $selectedCategories_5, ['class' => 'form-control full-width select2']) !!}
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <h4>Home Products Section 6 </h4>
    </div>

    <div class="form-group">
        <label for="home_products-section6" class="col-sm-2 control-label">Select Options</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
                {!! Form::select('products_section_6', $categories, $selectedCategories_6, ['class' => 'form-control full-width select2']) !!}
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <h4>Home Products Section 7 </h4>
    </div>

    <div class="form-group">
        <label for="home_products-section7" class="col-sm-2 control-label">Select Options</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
                {!! Form::select('products_section_7', $categories, $selectedCategories_7, ['class' => 'form-control full-width select2']) !!}
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <h4>Home Products Section 8 </h4>
    </div>

    <div class="form-group">
        <label for="home_products-section8" class="col-sm-2 control-label">Select Options</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
                {!! Form::select('products_section_8', $categories, $selectedCategories_8, ['class' => 'form-control full-width select2']) !!}
            </div>
        </div>
    </div>


      <br>
      
      <br>
      <div class="col-sm-12">
        <h4>Bulk Product Delete </h4>
    </div>
        <div class="form-group">
        <label for="home_products-section8" class="col-sm-2 control-label">Select Delete Product</label>
        <div class="col-sm-10">
            <div class="product-categories-dropdown">
                <select name="bulk_delete[]" class="form-control full-width select2" multiple>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <button type="submit" class="btn btn-danger btn-xs pull-right" name="submit">Update</button>
    </div>
{{-- 
</div> --}}