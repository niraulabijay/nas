<li class="uk-open">
    <a class="uk-accordion-title" href="#">
        <h5> Brand</h5>
    </a>
    <div class="uk-accordion-content brand__filter">
        @isset($brands)
        @foreach($brands as $brand)
        @isset($brand->slug)
            <label><input class="uk-checkbox item_filter brand" type="checkbox" name="brand" value="{{$brand->slug}}"> {{$brand->name}}</label>
             @endisset  
        @endforeach 
        
        @if(count($brands) > 5)
            <div class="more-filter" style="color: #c64732;font-weight: 500;font-size: 16px;">Load more</div>
            <div class="less-filter" style="color: #c64732;font-weight: 500;font-size: 16px;">Show less</div>
            @endif
        @endisset
    </div>
</li>
