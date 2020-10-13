<li class="uk-open">
    <a class="uk-accordion-title" href="#">
        <h5> Color</h5>
    </a>
    <div class="uk-accordion-content brand__filter color__filter">
        @if(isset($colour))
            @foreach($colour as $c)
                @if(!$c ==null)
                    <label><input class="uk-checkbox item_filter colour" type="checkbox" name="colour" id="{{$c}}" style="border-color:{{$c}}; border-width: 2px;" value="{{$c}}"> {{$c}}</label>
                @endif
            @endforeach
        @endif
        
        <div class="more-filter" style="color: #c64732;font-weight: 500;font-size: 16px;">Load more</div>
        <div class="less-filter" style="color: #c64732;font-weight: 500;font-size: 16px;">Show less</div>
    </div>
</li>