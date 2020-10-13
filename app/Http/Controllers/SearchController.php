<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductAdditional;
use DB;
use Illuminate\Http\Request;

class SearchController extends Controller {
    use PaginationHelper;

    public function getSearch(Request $request ) {
        $query = $request->get( 'query' );
        if(isset($query)){
            $queryParam  = explode(' ',$query);
        }
        else{
            $queryParam  = null;
        }

        $category = Category::where('name', 'like', '%' . $query . '%')
                    ->orWhere('slug', 'like', '%' . $query . '%')
                    ->first();
        if (!empty($category)) {
            $similarCategory = Category::whereHas('products')
                ->join('category_product','category_product.category_id','=','categories.id')
                ->join('products','products.id','=','category_product.product_id')
                ->where('categories.parent_id','=',$category->id)
                ->select(DB::raw('count(*) as count'),'categories.name','categories.slug')
                ->groupBy('categories.id')
                ->get();

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

            $categories = $this->addRelation( Category::where('slug', $category->slug)->get() );
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
            $products = Product::whereIn('id', $product_ids)->where( 'status', '=', 'published' )->get();
        }
        else {
            $products = Product::whereHas( 'categories', function ( $query ) use ( $queryParam ) {
                if (isset($queryParam)){
                    foreach($queryParam as $queries){
                        $query->where( 'products.slug', 'like', '%' . $queries . '%' );
                        $query->orWhere( 'products.name', 'like', '%' . $queries . '%' );
                        $query->orWhere( 'products.sku', 'like', '%' . $queries . '%' );
                        $query->where( 'products.status', '=', 'published' );
                        $query->where( 'products.approved', '=', 1 );
                    }
                }else{
                    $query->where( 'products.status', '=', 'published' );
                    $query->where( 'products.approved', '=', 1 );
                }
            } )->get();

            $similarCategory = Category::whereHas('products')
                ->join('category_product','category_product.category_id','=','categories.id')
                ->join('products','products.id','=','category_product.product_id')
                ->where('categories.parent_id','=',0)
                ->select(DB::raw('count(*) as count'),'categories.name','categories.slug')
                ->groupBy('categories.id')
                ->get();
        }
        $title = $query;
        if($request->ajax()){
            if($request->has('brand') ||  $request->has('size') || $request->has('colour') ||  $request->has('maxprice') || $request->has('minprice') ||$request->has('sort') ){

                // $query = Product::whereHas( 'categories', function ( $query ) use ( $queryParam ) {
                //     if (isset($queryParam)){
                //         foreach($queryParam as $queries){
                //             $query->where( 'products.slug', 'like', '%' . $queries . '%' );
                //             $query->orWhere( 'products.name', 'like', '%' . $queries . '%' );
                //             $query->orWhere( 'products.sku', 'like', '%' . $queries . '%' );
                //             $query->where( 'products.status', '=', 'published' );
                //             $query->where( 'products.approved', '=', 1 );
                //         }
                //     }else{
                //         $query->where( 'products.status', '=', 'published' );
                //         $query->where( 'products.approved', '=', 1 );
                //     }
                // } )
                //     ->join('category_product','category_product.product_id','=','products.id')
                //     ->join('categories','categories.id','=','category_product.category_id');

                if ($request->has('brand')) {
                    // $query->join('brands','brands.id','=','products.brand_id');
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
                //     ->where( 'products.status', '=', 'published' )
                //     ->where( 'products.approved', '=', 1 )

                //     ->groupBy('products.id')
                //     ->get();

                $products = $this->paginateHelper( $products, 20 );
                return view('front.category.product',compact('products'));
            }
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

    public function autoComplete(Request $request) {

        $queryParam = $request->get('query');
        $queryCategory = $request->get('category');

        if (isset( $queryCategory ) ) {
            $products = Product::whereHas('categories', function ( $query ) use ( $queryParam,$queryCategory ) {
                $query->where( 'categories.id', $queryCategory );
                $query->where( 'products.status', '=', 'published' );
                $query->where( 'products.approved', '=', 1 );
                $query->where( 'products.name','like', '%' . $queryParam . '%'  );
                $query->orWhere( 'products.slug','like', '%' . $queryParam . '%'  );
                $query->orWhere( 'products.sku','like', '%' . $queryParam . '%'  );
            })
                ->join('product_images','products.id','=','product_images.product_id')->where('product_images.is_main_image', '=', 1)
                ->select('products.id','products.name','product_images.path','products.slug','products.product_price','products.short_description')
                ->where('products.status', '=','published')
                ->take(4)
                ->get();
            return response()->json($products);

        }
        else{

            $products = Product::whereHas('categories', function ( $query ) use ( $queryParam ) {
                $query->where( 'products.status', '=', 'published' );
                $query->where( 'products.approved', '=', 1 );
                $query->where( 'products.name','like', '%' . $queryParam . '%'  );
                $query->orWhere( 'products.slug','like', '%' . $queryParam . '%'  );
                $query->orWhere( 'products.sku','like', '%' . $queryParam . '%'  );
            })
                ->join('product_images','products.id','=','product_images.product_id')->where('product_images.is_main_image', '=', 1)
                ->select('products.id','products.name','product_images.path','products.slug','products.product_price')
                ->where('products.status', '=','published')
                ->take(4)
                ->get();

            return response()->json($products);
        }
    }

    public function autoCategory(Request $request){
        $queryParam = $request->get('query');
        $queryCategory = $request->get('category');

        if ( isset( $queryCategory )) {
            $results = array();
            $products = DB::table('products')
                ->join('category_product', 'category_product.product_id', '=', 'products.id')
                ->join('categories', 'categories.id', '=', 'category_product.category_id')
                ->where(function($query) use ($queryCategory,$queryParam){
                    $query->where('products.status', '=','published');
                    $query->where( 'products.approved', '=', 1 );
                    $query->where('categories.id', '=', $queryCategory);
                    $query->where('products.name', 'LIKE', '%' . $queryParam . '%'  );
                })
                ->select(DB::raw('count(*) as count'),'products.name as productname', 'categories.name as catname','categories.slug as catslug', 'categories.id as catid')
                ->where('products.status', '=','published')
                ->groupBy('categories.id')
                ->take(3)
                ->get();
            foreach ($products as $product) {
                $results[] = [
                    'count' => $product->count,
                    'productname' => $product->productname,
                    'catname' => $product->catname ,
                    'catid' => $product->catid,
                    'catslug'=>$product->catslug ,
                    'query' =>$queryParam
                ];
            }
            return response()->json($results);
        }
        else {
            $results = array();
            $products = DB::table('products')
                ->select(DB::raw('count(*) as count'),'products.name as productname', 'categories.name as catname','categories.slug as catslug', 'categories.id as catid')
                ->join('category_product', 'category_product.product_id', '=', 'products.id')
                ->join('categories', 'categories.id', '=', 'category_product.category_id')
                ->where('products.status', '=', 'published')
                ->where( 'products.approved', '=', 1 )
                ->where('products.name', 'LIKE', '%' . $queryParam . '%'  )
                ->distinct()
                ->groupBy('categories.id')
                ->take(3)
                ->get();


            foreach ($products as $product) {
                $results[] = [
                    'count' => $product->count,
                    'productname' => $product->productname,
                    'catname' => $product->catname ,
                    'catid' => $product->catid,
                    'catslug'=>$product->catslug ,
                    'query' =>$queryParam
                ];
            }
            return response()->json($results);

        }

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
