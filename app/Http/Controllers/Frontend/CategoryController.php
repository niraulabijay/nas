<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductAdditional;

use Illuminate\Support\Facades\DB;
use App\Model\VendorDetail;
use Illuminate\Http\Request;


class CategoryController extends Controller

{
    use PaginationHelper;

    public function test(Request $request)
    {
        $first_id = $request->itemsarray[0];
        $second_id = $request->itemsarray[1];
        $first = Product::findOrFail($first_id);
        $second = Product::findOrFail($second_id);
          return response()->json([
               'first' => $first,
               'second' => $second
          ]);
    }

    public function compare($slug1, $slug2)
    {
        $first = Product::where('slug', $slug1)->first();
        $second = Product::where('slug', $slug2)->first();
        return view('front.category.compare', compact('first', 'second'));
    }

    public function getCategoryProducts( Request $request ,$slug) {

        if($request->ajax()){

            if($request->has('brand') ||  $request->has('size') || $request->has('colour') ||  $request->has('maxprice') || $request->has('minprice') || $request->has('sort') ){
                $categories = $this->addRelation( Category::where('slug', $slug)->get() );
                $category_ids = array();
                foreach ($categories as $category) {
                    $category_ids[] = $category->id;
                    if($category->subCategory->isNotEmpty()){
                        foreach ($category->subCategory as $sub) {
                            $category_ids[] = $sub->id;
                            if($sub->subCategory->isNotEmpty()){
                                foreach ($sub->subCategory as $child) {
                                    $category_ids[] = $child->id;
                                    if($child->subCategory->isNotEmpty()){
                                        foreach ($child->subCategory as $cat) {
                                            $category_ids[] = $cat->id;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $product_ids = DB::table('category_product')->whereIn('category_id', $category_ids)->pluck('product_id')->toArray();
                // dd($product_ids);
                $products = Product::whereIn('id', $product_ids)->where( 'status', '=', 'published' )->where('approved', 1)->get();
                
       
                
                // $query = Product::whereHas('categories')
                //     ->join('category_product','category_product.product_id','=','products.id')
                //     ->join('categories','categories.id','=','category_product.category_id');
                if ($request->has('brand')) {
                    // $query->join('brands','brands.id','=','products.brand_id');
                    // dd($request->brand);
                    $brands = Brand::whereIn('slug', $request->brand)->pluck('id')->toArray();
                    $products = $products->whereIn('brand_id', $brands);
                }
                if ($request->has('size')) {
                    // $query->whereIn('product_additionals.size', $request->size);
                    $size = ProductAdditional::whereIn('size', $request->size)->pluck('product_id')->toArray();
                    $products = $products->whereIn('id', $size);
                }
                if ($request->has('colour')) {
                    $products = $products->whereIn('color', $request->colour);
                }
                if ($request->has('minprice') && $request->has('maxprice') ) {
                    $min=$request->minprice;
                    $max=$request->maxprice;
                    if(isset($min) && isset($max)){
                        // $products = $products->whereBetween('sale_price', [$request->minprice,$request->maxprice]);
                        $products = $products->where('sale_price', '>=', $request->minprice)->where('sale_price', '<=', $request->maxprice);
                    }
                }

                if($request->has('sort') ){
                    $sortBy=$request->sort;

                    if(isset($sortBy)){
                        if ($sortBy == 'popular') {
                            $products = $products->sortByDesc('view');
                        }
                        if ($sortBy == 'new') {
                            $products = $products->sortByDesc('created_at');
                        }
                        if ($sortBy == 'old') {
                            $products = $products->sortBy('created_at');
                        }
                        if ($sortBy == 'a-z') {
                            $products = $products->sortBy('name');
                        }
                        if ($sortBy == 'z-a') {
                            $products = $products->sortByDesc('name');
                        }
                        if ($sortBy == 'high-low') {
                            $products = $products->sortByDesc('sale_price');
                        }
                        if ($sortBy == 'low-high') {
                            $products = $products->sortBy('sale_price');
                        }
                    }
                }

                // $products = $query->select('products.*')
                //     ->where('categories.slug',$slug)
                //     ->where('products.status','=',1)
                //     ->groupBy('products.id')
                //     ->get();
                $products = $this->paginateHelper( $products, 20 );

                return view('front.category.product',compact('products'));
            }

        }

        $category = Category::where('slug', $slug)->first();
        if(!isset($category)){
            return  redirect()->back()->with('error','No Category Found');
        }
        $title= $category->name;
        $similarCategory = Category::whereHas('products')
            ->join('category_product','category_product.category_id','=','categories.id')
            ->join('products','products.id','=','category_product.product_id')
            ->where('categories.parent_id','=',$category->id)
            ->select(DB::raw('count(*) as count'),'categories.name','categories.slug')
            ->groupBy('categories.id')
            ->get();

        $categories = $this->addRelation( Category::where('slug', $slug)->get() );
        $category_ids = array();
        foreach ($categories as $category) {
            $category_ids[] = $category->id;
            if($category->subCategory->isNotEmpty()){
                foreach ($category->subCategory as $sub) {
                    $category_ids[] = $sub->id;
                    if($sub->subCategory->isNotEmpty()){
                        foreach ($sub->subCategory as $child) {
                            $category_ids[] = $child->id;
                            if($child->subCategory->isNotEmpty()){
                                foreach ($child->subCategory as $cat) {
                                    $category_ids[] = $cat->id;
                                }
                            }
                        }
                    }
                }
            }
        }
        $product_ids = DB::table('category_product')->whereIn('category_id', $category_ids)->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $product_ids)->where( 'status', '=', 'published' )->where('approved', 1)->orderBy('id', 'DESC')->get();
                if ($request->has('brand')) {
                    // $query->join('brands','brands.id','=','products.brand_id');
                    // dd($request->brand);
                    $brands = Brand::whereIn('slug', $request->brand)->pluck('id')->toArray();
                    $products = $products->whereIn('brand_id', $brands);
                }
                if ($request->has('size')) {
                    // $query->whereIn('product_additionals.size', $request->size);
                    $size = ProductAdditional::whereIn('size', $request->size)->pluck('product_id')->toArray();
                    $products = $products->whereIn('id', $size);
                }
                if ($request->has('colour')) {
                    $products = $products->whereIn('color', $request->colour);
                }
                if ($request->has('minprice') && $request->has('maxprice') ) {
                    $min=$request->minprice;
                    $max=$request->maxprice;
                    if(isset($min) && isset($max)){
                        // $products = $products->whereBetween('sale_price', [$request->minprice,$request->maxprice]);
                        $products = $products->where('sale_price', '>=', $request->minprice)->where('sale_price', '<=', $request->maxprice);
                    }
                }

        if($products->isEmpty()) {
            $products= Product::whereHas('categories')
                ->join('category_product','category_product.product_id','=','products.id')
                ->join('categories','categories.id','=','category_product.category_id')
                ->select('products.*')
                ->where('products.status','=',1)
                ->where('categories.slug',$slug)
                ->groupBy('products.id')
                ->get();
        }
        if($similarCategory->isEmpty())
        {
            $similarCategory = Category::whereHas('products')
            ->join('category_product','category_product.category_id','=','categories.id')
            ->join('products','products.id','=','category_product.product_id')
            ->where('categories.parent_id','=',$category->parent_id)
            ->select(DB::raw('count(*) as count'),'categories.name','categories.slug')
            ->groupBy('categories.id')
            ->get();
        }


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
                $brand[]=Brand::where('id',$product->brand_id)->first();
                $product_id[]=$product->brand_id;
            }
            if(!empty($brand)){
                $brands = array_unique($brand);
            }
        }
        

        $products = $this->paginateHelper( $products, 20 );
        return view('front.category.category',compact('products','title','similarCategory','brands','product_id','colour','size', 'category'));
   }
   
   
   
       public function getVendorProducts($slug) {
      
        if($slug == 'nepalallshop'){
          $vendor ='Nepal All Shop';
       
        $products = Product::where('user_id', 1)->paginate(30);
        $getVendorProducts = Product::where('user_id', 1)->get();  
            
        }else{
            $vendorDetail =  VendorDetail::where('vendor_code', strtoupper($slug))->first();
            $vendor =$vendorDetail->name;
       
        $products = Product::where('user_id', $vendorDetail->user_id)->paginate(30);
        $getVendorProducts = Product::where('user_id', $vendorDetail->user_id)->get();
        }
        $brands = Brand::whereIn('id', $getVendorProducts->pluck('brand_id'))->get();
        $productCategories = DB::table('category_product')->whereIn('product_id', $getVendorProducts->pluck('id'))->get();
      
        $categories = Category::where('id', $productCategories->pluck('category_id'))->get();
       
        
       
        return view('front.vendorproduct',compact('vendor','products', 'brands', 'categories'));
   }

   

   public function selectChild( $id ) {
        $categories = Category::where( 'parent_id', $id )->get(); //rooney

        $categories = $this->addRelation( $categories );

        return $categories;

    }

    public function addRelation( $categories ) {

        $categories->map( function ( $item, $key ) {

            $sub = $this->selectChild( $item->id );

            return $item = array_add( $item, 'subCategory', $sub );

        } );

        return $categories;
    }
   
}
