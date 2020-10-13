<?php

namespace App\Http\Controllers\backend;

use App\DeliveryCharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    public function index()
    {
        return view('admin.shipping_amount.index');
    }

    public function create()

    {
        $areas=DeliveryCharge::where('parent_id',0)->get();
        $areas = $this->addRelation( $areas );

        return view('admin.shipping_amount.create',compact('areas'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',

        ]);
//        dd($request);


        $shipping_amount = new DeliveryCharge();
        $shipping_amount->name = $request->name;
        $shipping_amount->value = $request->value;
        $shipping_amount->type = $request->type;
        $shipping_amount->parent_id=$request->parent_id;
        $shipping_amount->save();

        return redirect()->back()->with('success', 'Shipping Amount Successfully Saved.');
    }

    public function edit($id)
    {
        $shipping_amount = DeliveryCharge::findOrFail($id);
        $areas=DeliveryCharge::where('parent_id',0)->get();
        $areas = $this->addRelation( $areas );

        return view('admin.shipping_amount.edit', compact('shipping_amount','areas'));
    }
    public function addRelation( $areas ) {

        $areas->map( function ( $item, $key ) {

            $sub = $this->selectChild( $item->id );

            return $item = array_add( $item, 'subCategory', $sub );

        } );

        return $areas;
    }

    public function selectChild( $id ) {
        $categories = DeliveryCharge::where( 'parent_id', $id )->get(); //rooney

        $categories = $this->addRelation( $categories );

        return $categories;

    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $shipping_amount = DeliveryCharge::findOrFail($request->id);
        $shipping_amount->name = $request->name;
        $shipping_amount->value = $request->value;
        $shipping_amount->type = $request->type;
        $shipping_amount->parent_id = $request->parent_id;

        $shipping_amount->update();

        return redirect()->back()->with('success', 'Shipping Amount Successfully Updated.');
    }

    public function destroy($id)
    {
        $shipping_amount = DeliveryCharge::findOrFail($id);
        $shipping_amount->delete();
        return response()->json('Shipping Amount Successfully Deleted.');
    }

    public function getShippingAmountJson()
    {
        $shipping_amounts = DeliveryCharge::all();
        foreach ( $shipping_amounts as $categoryKey => $categoryValue ) {
            $parent_id=DeliveryCharge::where('id',$categoryValue->parent_id)->first();
            $shipping_amounts[ $categoryKey ]['parent'] = isset( $parent_id->name ) ? $parent_id->name : '-';

        }
        return datatables($shipping_amounts)->toJson();
    }
}
