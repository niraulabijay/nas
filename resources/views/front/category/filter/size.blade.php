<li class="uk-open">
    <a class="uk-accordion-title" href="#">
        <h5> Size</h5>
    </a>
    <div class="uk-accordion-content brand__filter size__filter">
        @if(isset($size))
            @foreach($size as $s)
                @if(!$s ==null)
                    <label><input class="uk-checkbox item_filter size" type="checkbox" name="size" value="{{$s->size}}"> {{$s->size}}</label>
                @endif
            @endforeach
            
           @if(count($size) > 5)
            <div class="more-filter" style="color: #c64732;font-weight: 500;font-size: 16px;">Load more</div>
            <div class="less-filter" style="color: #c64732;font-weight: 500;font-size: 16px;">Show less</div>
            @endif
        @endif
    </div>
</li>

