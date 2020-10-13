<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Deal;
use App\Model\Category;
use App\User;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DealController extends Controller
{
	public function index()
	{
        // $deal=Deal::findOrFail(1);
        // $val=$deal->products()->orderBy(DB::raw('LENGTH(priority), priority'))->get();
        // dd($val);
		return view('admin.deals.index');
	}

    public function create()
    {
    	return view('admin.deals.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

    	$deal = new Deal;
    	$deal->name = $request->input('name');
    	$deal->save();
    	return redirect()->back()->with('success', 'Deal Successfully Added');
    }

    public function edit($id)
    {
    	$deals = Deal::findOrFail($id);
    	return view('admin.deals.edit', compact('deals'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

    	$deals = Deal::findOrFail($request->id);
    	$deals->name = $request->input('name');
    	$deals->update();
    	return redirect(route('admin.deals.index'))->with('success', 'Deal Successfully Updated');
    }

    public function destroy($id)
    {
    	$deal = Deal::findOrFail($id);
    	$deal->deal_product()->delete();
    	$deal->delete();
    	return response()->json('Deal Successfully Deleted');
    }

    public function getDealsJson()
    {
    	$deals = Deal::all();
    	return datatables($deals)->toJson();
    }

    public function dealProduct($id, Request $request)
    {
    	$deal = Deal::findOrFail($id);
    	$categories = Category::all();
    	$vendors = User::with(['roles' => function($q){
                        $q->where('name', 'vendor');
                    }])->get();
        
        if(request()->input('vendor_sort') != '')
        {
            $vendor_id = request()->input('vendor_sort');
            $products = Product::where('user_id', $vendor_id)->get();
        }
        elseif(request()->input('category_sort')!= '')
        {
            $category_id = request()->input('category_sort');
            $products = Product::whereHas('categories', function ($query) use ($category_id) {
                $query->where('categories.id', $category_id);
            })->get();
        }
        else
        {
            $products = Product::all();
        }
    	return view('admin.deals.deal_product', compact('deal', 'categories', 'vendors', 'products'));
    }

    public function getDealProductAddJson()
    {
    	$products = Product::all();
    	return datatables($products)->toJson();
    }

    public function dealProductStore(Request $request)
    {
    	$deal = Deal::findOrFail($request->deal_id);
    	$product = Product::findOrFail($request->product_id);
    	$deal_product = DB::table('deal_product')->where('deal_id', $request->deal_id)->where('product_id', $request->product_id)->first();
        if($deal_product)
        {
            $product->deals()->sync($request->deal_id);
        }
        else
        {
            $product->deals()->attach($request->deal_id); 
        // $priority = DB::table('deal_product')->insert(['priority' => $request->priority], ['deal_id' => $request->deal_id]);
        // dd($request->priority);
	    }

    	return response()->json( [
			'status'  => 'success',
			'message' => 'Product successfully added to '.$deal->name
		], 200 ); 
    }

    public function getDealProductJson($id)
    {
    	$deal = Deal::findOrFail($id);
    	$products = $deal->products()->get();
    	return datatables($products)->toJson();
    }

    public function deleteDealProduct($id)
    {
    	// $deal = Deal::findOrFail($id);
    	$product = Product::findOrFail($id);
    	 $product->deals()->detach();
    	return response()->json( [
			'status'  => 'success',
			'message' => 'Product successfully deleted. '
		], 200 );
    }
}
