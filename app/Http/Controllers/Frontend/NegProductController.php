<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Brand;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductAdditional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\PaginationHelper;

class NegProductController extends Controller
{
    use PaginationHelper;

    public function getNegProducts(Request $request){



       $count = 12;
       $title = "Products";


      $products=Product::where('negotiable', '1')->where('status','1')->where('approved','1')->get();
           $similarCategory = Category::where('parent_id',0)->get();



       foreach ($products as $product){
           $brand[]=Brand::where('id',$product->brand_id)->first();
           $product_id[]=$product->brand_id;

       }
       if (request()->has('sort')) {
            if (request()->input('sort') == 'popular') {
                $products = Product::where('negotiable', '1')->where( 'status', '=', 1 )->where('approved',1)->orderBy('id', 'DESC')->get();
            }
            if (request()->input('sort') == 'new') {
                $products = Product::where('negotiable', '1')->where( 'status', '=', 1 )->where('approved',1)->orderBy('created_at', 'DESC')->get();
            }
            if (request()->input('sort') == 'old') {
                $products = Product::where('negotiable', '1')->where( 'status', '=', 1 )->where('approved',1)->orderBy('created_at', 'ASC')->get();
            }
            if (request()->input('sort') == 'a-z') {
                $products = Product::where('negotiable', '1')->where( 'status', '=', 1 )->where('approved',1)->orderBy('name', 'ASC')->get();
            }
            if (request()->input('sort') == 'z-a') {
                $products = Product::where('negotiable', '1')->where( 'status', '=', 1 )->where('approved',1)->orderBy('name', 'DESC')->get();
            }
            if (request()->input('sort') == 'high-low') {
                $products = Product::where('negotiable', '1')->where( 'status', '=', 1 )->where('approved',1)->orderBy('sale_price', 'DESC')->get();
            }
            if (request()->input('sort') == 'low-high') {
                $products = Product::where('negotiable', '1')->where( 'status', '=', 1 )->where('approved',1)->orderBy('sale_price', 'ASC')->get();
            }
        }
//        if($request->has('discount')){
//            if (request()->input('discount') == '0_10') {
//                $products = $category->products->whereColumn('product_price-sale_price\product_price','<',0.10);
//                    dd($products);
//                if (request()->input('sort') == '10_20') {
//                    $products = $products->orderBy('created_at', 'DESC')->get();
//                }
//                if (request()->input('sort') == '20_30') {
//                    $products = $products->orderBy('product_name', 'ASC')->get();
//                }
//                if (request()->input('sort') == '30_40') {
//                    $products = $products->orderBy('product_name', 'DESC')->get();
//                }
//                if (request()->input('sort') == '40+') {
//                    $products = $products->orderBy('sale_price', 'DESC')->get();
//                }
//            }
//
//        }
       if($request->has('brand')){
           $brand_slug=$request->input('brand');
           $brand_id=Brand::where('slug',$brand_slug)->first()->id;

           $products=Product::where('negotiable',1)->where('status','1')->where('approved','1')->where('brand_id',$brand_id)->get();



       }
       if($request->has('colour')) {
           $colour = $request->input('colour');
           $products = Product::where('negotiable',1)->where('status','1')->where('approved','1')->whereHas('additionals', function ($query) use ($colour) {
               $query->where('color', $colour);

           })->get();
       }
       if($request->has('size')){
           $size=$request->input('size');
           $products = Product::where('negotiable',1)->where('status','1')->where('approved','1')->whereHas('additionals',function ($query)use ($size) {
               $query->where('size', $size);

           })->get();


        }
        $min = request()->input('min');
        $max = request()->input('max');
        if (  isset( $min )  && isset( $min )) {
            $products = Product::where('negotiable',1)->where('status','1')->where('approved','1')
                ->where('sale_price', '>', $min)
                ->where('sale_price', '<', $max)
                ->get();
        }
        if(!empty($brand)){
            $brands = array_unique($brand);
        }
        else
        {
            $brands=Brand::all();
        }
//$colour=Product::whereHas( 'categories', function ( $query ) use ( $category  ) {
//    $query->where('categories.id', $category->id);
//})->get();
       $color=ProductAdditional::all()->pluck('color')->toArray();
       $colour=array_unique($color);
       $sizes=ProductAdditional::all()->pluck('size')->toArray();
       $size=array_unique($sizes);
//dd($colour);

       $products = $this->paginateHelper( $products, 20 );
       return view('front.category.category',compact('products','title','similarCategory','brands','product_id','colour','size'));
   }

}
