<?php

namespace App\Http\Controllers\Backend;

use App\Model\ShippingAmount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingAmountController extends Controller
{
    public function index()
    {
        return view('admin.shipping_amount.index');
    }

    public function create()
    {
        return view('admin.shipping_amount.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'place' => 'required',
            'amount' => 'required|numeric'
        ]);

        $shipping_amount = new ShippingAmount();
        $shipping_amount->place = $request->place;
        $shipping_amount->amount = $request->amount;
        $shipping_amount->save();

        return redirect()->back()->with('success', 'Shipping Amount Successfully Saved.');
    }

    public function edit($id)
    {
        $shipping_amount = ShippingAmount::findOrFail($id);
        return view('admin.shipping_amount.edit', compact('shipping_amount'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'place' => 'required',
            'amount' => 'required|numeric'
        ]);

        $shipping_amount = ShippingAmount::findOrFail($request->id);
        $shipping_amount->place = $request->place;
        $shipping_amount->amount = $request->amount;
        $shipping_amount->update();

        return redirect()->back()->with('success', 'Shipping Amount Successfully Updated.');
    }

    public function destroy($id)
    {
        $shipping_amount = ShippingAmount::findOrFail($id);
        $shipping_amount->delete();
        return response()->json('Shipping Amount Successfully Deleted.');
    }

    public function getShippingAmountJson()
    {
        $shipping_amounts = ShippingAmount::all();

        return datatables($shipping_amounts)->toJson();
    }
}
