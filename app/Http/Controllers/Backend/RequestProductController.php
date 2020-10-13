<?php

namespace App\Http\Controllers\Backend;

use App\Model\RequestProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestProductController extends Controller
{
    public function index()
    {
        $requests = RequestProduct::all();
        return view('admin.requests.index', compact('requests'));
    }
    
    public function edit($id)
    {
        $request = RequestProduct::findOrFail($id);
        return view('admin.requests.edit', compact('request'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request,[
    		'name' => 'required',
    		'email' => 'required|email',
    		'phone' => 'required|digits:10',
    		'title' => 'required',
    		'product_specification' => 'required'
    	]);
    	
        $request_product = RequestProduct::findOrFail($id);
        $request_product->name = $request->name;
        $request_product->email = $request->email;
    	$request_product->phone = $request->phone;
    	$request_product->product_title = $request->title;
    	$request_product->product_specification = $request->product_specification;
    	$request_product->product_reference = $request->reference;
    	$request_product->product_category = $request->category;

    	$request_product->update();
    	
    	return redirect()->route('admin.request_product')->with('success', 'Request Product successfully updated.');
    }
    
    public function destroy($id)
    {
        $request = RequestProduct::findOrFail($id);
        $request->delete();
        return response()->json('Requested Product successfully deleted.');
    }
    
    public function getRequestProductJson()
    {
        $requests = RequestProduct::all();
        return datatables($requests)->toJson();
    }
}
