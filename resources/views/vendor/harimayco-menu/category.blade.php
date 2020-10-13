@if($category->subCategory->isNotEmpty())
    <ul class="no-list-style pl-20" style="list-style: none;margin-left: -20px;">
        @foreach($category->subCategory as $child)
            <li>
                <label class="menu-item-title">
                    <input type="checkbox"
                           class="menu-item-checkbox"
                           name="menu-item"
                           value="{{ route('home.index') . '/category/' . $child->slug }}" data-label="{{ $child->name }}">
                    {{ $child->name }}
                </label>
            </li>
            @include('vendor.harimayco-menu.category', ['category' => $child])
        @endforeach
    </ul>
@endif