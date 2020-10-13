<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CouponRequest;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Coupon;
use App\Model\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $categories = Category::where('parent_id', '0')->orWhere('parent_id', '1')->pluck('name', 'id')->toArray();
        $brands = Brand::pluck('name', 'id')->toArray();
        $products = Product::pluck('name', 'id')->toArray();
        $vendors = User::with(['roles' => function($q){
                        $q->where('name', 'vendor');
                    }])->pluck('user_name', 'id')->toArray();
        return view('admin.coupons.create', compact('categories', 'brands', 'products', 'vendors'));
    }

    public function store(CouponRequest $request)
    {
        try {
            $coupon = new Coupon();
            $coupon->name = $request->name;
            $coupon->description = $request->description;
            $coupon->code = $request->code;
            $coupon->discount_value = $request->discount_value;
            $coupon->max_discount_value = $request->max_discount_value;
            $coupon->start_date = $request->start_date;
            $coupon->end_date = $request->end_date;
            $coupon->uses_per_coupon = $request->uses_per_coupon;
            $coupon->save();

            if ($request->product) {
                $coupon->products()->attach($request->product);
            }
            if ($request->category) {
                $category_product = DB::table('category_product')->where('category_id', $request->category)
                    ->pluck('product_id', 'product_id')->toArray();
                $coupon->products()->attach($category_product);
            }
            if ($request->brand) {
                $product = Product::where('brand_id', $request->brand)->pluck('id', 'id')->toArray();
                $coupon->products()->attach($product);
            }
            if($request->vendor) {
                $vendor = Product::where('user_id', $request->vendor)->pluck('id', 'id')->toArray();
                $coupon->products()->attach($vendor);
            }
        }
        catch (Exception $e)
        {
            throw new Exception( 'Error in saving coupon: ' . $e->getMessage() );
        }

        return redirect()->back()->with(['success' => 'Coupon is created successfully!']);
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $categories = Category::where('parent_id', '0')->orWhere('parent_id', '1')->pluck('name', 'id')->toArray();
        $brands = Brand::pluck('name', 'id')->toArray();
        $products = Product::pluck('name', 'id')->toArray();
        $vendors = User::with(['roles' => function($q){
                        $q->where('name', 'vendor');
                    }])->pluck('user_name', 'id')->toArray();
        return view('admin.coupons.edit', compact('coupon', 'categories', 'brands', 'products', 'vendors'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:coupons,code,' . $request->id,
            'discount_value' => 'required|numeric',
            // 'max_discount_value' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'uses_per_coupon' => 'required|numeric'
        ]);

        try {
            $coupon = Coupon::findOrFail($request->id);
            $coupon->name = $request->name;
            $coupon->description = $request->description;
            $coupon->code = $request->code;
            $coupon->discount_value = $request->discount_value;
            $coupon->max_discount_value = $request->max_discount_value;
            $coupon->start_date = $request->start_date;
            $coupon->end_date = $request->end_date;
            $coupon->uses_per_coupon = $request->uses_per_coupon;
            $coupon->update();

            if ($request->product) {
                $coupon->products()->syncWithoutDetaching($request->product);
            }
            if ($request->category) {
                $category_product = DB::table('category_product')->where('category_id', $request->category)
                    ->pluck('product_id', 'product_id')->toArray();
                $coupon->products()->syncWithoutDetaching($category_product);
            }
            if ($request->brand) {
                $product = Product::where('brand_id', $request->brand)->pluck('id', 'id')->toArray();
                $coupon->products()->syncWithoutDetaching($product);
            }
            if($request->vendor) {
                $vendor = Product::where('user_id', $request->vendor)->pluck('id', 'id')->toArray();
                $coupon->products()->syncWithoutDetaching($vendor);
            }
        }
        catch (Exception $e)
        {
            throw new Exception( 'Error in updating coupon: ' . $e->getMessage() );
        }

        return redirect()->back()->with(['success' => 'Coupon is updated successfully!']);
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->products()->detach();
        $coupon->delete();
        return redirect()->back()->with(['success' => 'Coupon is deleted successfully!']);
    }
}
