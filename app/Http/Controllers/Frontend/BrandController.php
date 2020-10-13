<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Deal;
use App\Model\Product;
use App\Model\ProductAdditional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    use PaginationHelper;

    public function getBrandProducts(Request $request,$slug)
    {
      $brand=Brand::where('slug',$slug)->first();
      $title = $brand->name;

     if($request->ajax()){

            if($request->has('brand') ||  $request->has('size') || $request->has('colour') ||  $request->has('maxprice') || $request->has('minprice') || $request->has('sort') ){
                $query = Product::whereHas('categories')
                    ->join('category_product','category_product.product_id','=','products.id')
                    ->join('categories','categories.id','=','category_product.category_id');
                if ($request->has('brand')) {
                    $query->join('brands','brands.id','=','products.brand_id');
                    $query->whereIn('brands.slug', $request->brand);
                }
                if ($request->has('size')) {
                    $query->whereIn('product_additionals.size', $request->size);
                }
                if ($request->has('colour')) {
                    $query->whereIn('product_additionals.color', $request->colour);
                }
                if ($request->has('colour') ||  $request->has('size') ){
                    $query->join('product_additionals','product_additionals.product_id','=','products.id');

                }
                if ($request->has('minprice') && $request->has('maxprice') ) {
                    $min=$request->minprice;
                    $max=$request->maxprice;
                    if(isset($min) && isset($max)){
                        $query->whereBetween('products.sale_price', [$request->minprice,$request->maxprice]);
                    }
                }

                if($request->has('sort') ){
                    $sortBy=$request->sort;

                    if(isset($sortBy)){
                        if ($sortBy == 'popular') {
                            $query->orderBy('id', 'DESC');
                        }
                        if ($sortBy == 'new') {
                            $query->orderBy('created_at', 'DESC');
                        }
                        if ($sortBy == 'old') {
                            $query->orderBy('created_at', 'ASC');
                        }
                        if ($sortBy == 'a-z') {
                            $query->orderBy('name', 'ASC');
                        }
                        if ($sortBy == 'z-a') {
                            $query->orderBy('name', 'DESC');
                        }
                        if ($sortBy == 'high-low') {
                            $query->orderBy('sale_price', 'DESC');
                        }
                        if ($sortBy == 'low-high') {
                            $query->orderBy('sale_price', 'ASC');
                        }
                    }
                }

                $products = $query->select('products.*')
                    ->where('products.brand_id',$brand->id)
                    ->where('products.status','=',1)
                    ->groupBy('products.id')
                    ->get();
                $products = $this->paginateHelper( $products, 20 );

                return view('front.category.product',compact('products'));
            }

        }
     
      $similarCategory = Category::whereHas('products')
            ->join('category_product','category_product.category_id','=','categories.id')
            ->join('products','products.id','=','category_product.product_id')
            ->where('categories.parent_id','=', 0)
            ->select(DB::raw('count(*) as count'),'categories.name','categories.slug')
            ->groupBy('categories.id')
            ->get();
        $products = $brand->products()->where('brand_id', $brand->id)->get();

        if(isset($products) && $products->count()>0){
            $colors = $products->where('color', '!=', null)->pluck('color')->toArray();
            $collect = collect($colors);
            $colour = $collect->unique();
            $colour->values()->all();

            foreach($products as $product){
                $siz=Product::whereHas('additionals')
                    ->join('product_additionals', 'product_additionals.product_id', '=', 'products.id')
                    ->select('product_additionals.size')
                    ->where('products.id','=',$product->id)
                    ->get();

                if(isset($siz) && $siz->count()>0){
                    foreach($siz as $sizes){
                        $si[]=$sizes;
                    }
                    $collect = collect($si);
                    $size = $collect->unique();
                    $size->values()->all();
                }
            }

            foreach ($products as $product){
                $brands[] = Brand::where('id', $product->brand_id)->first();
                $product_id[] = $product->brand_id;
            }
            if(!empty($brands)){
                $brands = array_unique($brands);
            }
        }

      $products = $this->paginateHelper( $products, 20 );
      return view('front.category.category',compact('products','title','similarCategory','brands','product_id','colour','size'));
  }

    public function getDealProducts(Request $request,$slug){
      $count = 12;
      $title = 'Products';

      $similarCategory = Category::where('parent_id',0)->get();

      $products = Product::all();
      foreach ($products as $product){
          $brand[]=Brand::where('id',$product->brand_id)->first();
          $product_id[]=$product->brand_id;

      }
      if (request()->has('sort')) {
          if (request()->input('sort') == 'popular') {
              $products =  Product::orderBy('id', 'DESC')->get();
              if (request()->input('sort') == 'new') {
                  $products =  Product::orderBy('created_at', 'DESC')->get();
              }
              if (request()->input('sort') == 'a-z') {
                  $products =  Product::orderBy('name', 'DESC')->get();
              }
              if (request()->input('sort') == 'z-a') {
                  $products =  Product::orderBy('name', 'ASC')->get();
              }
              if (request()->input('sort') == 'high-low') {
                  $products =  Product::orderBy('sale_price', 'DESC')->get();
              }
          }
          if (request()->input('sort') == 'low-high') {
              $products =  Product::orderBy('sale_price', 'ASC')->get();
          }
      }
      if($request->has('brand')){
          $brand_slug=$request->input('brand');
          $brand_id=Brand::where('slug',$brand_slug)->first()->id;

          $products=$brand->products()->where('brand_id',$brand_id)->get();
      }
      if($request->has('colour')) {
          $colour = $request->input('colour');
          $products = $brand->products()->whereHas('additionals', function ($query) use ($colour) {
              $query->where('color', $colour);

          })->get();
      }
      if($request->has('size')){
          $size=$request->input('size');
          $products = $brand->products()->whereHas('additionals',function ($query)use ($size) {
              $query->where('size', $size);

          })->get();


      }
          $min = request()->input('min');
        $max = request()->input('max');
        if (  isset( $min )  && isset( $min )) {
            $products =Product::
                where('sale_price', '>', $min)
                ->where('sale_price', '<', $max)
                ->get();
        }
     
         if(!empty($brand)){
      $brands = array_unique($brand);}
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
