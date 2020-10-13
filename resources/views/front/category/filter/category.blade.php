<li class="uk-open">
    <a class="uk-accordion-title" href="#">
        <h5> Category</h5>
    </a>
    <div class="uk-accordion-content">
        <div class="scrollbar   mCustomScrollbar">
            <ul>
                @foreach($categorys as $category)
                <li class="category-list">
                    <a class="link-category" href="{{route('category',['slug'=>$category->slug])}}">{{$category->name}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</li>