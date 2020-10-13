<option value="0" disabled selected >Select Option</option>

@foreach(\App\DeliveryCharge::where('parent_id',$id)->get() as $zones)
<option value="{{$zones->id}}">{{$zones->name}}</option>
@endforeach