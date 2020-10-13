<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductAdditional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    use PaginationHelper;

    public function searchProducts(Request $request)
    {
    	$qry = $request->get( 'query' );
        if(isset($qry)){
            $queryParam  = explode(' ',$qry);
        }
        else{
            $queryParam  = null;
        }

        $category = Category::where('name', 'like', '%' . $qry . '%')
                    ->orWhere('slug', 'like', '%' . $qry . '%')
                    ->first();
        if (!empty($category)) {

            $categories = addRelation( Category::where('slug', $category->slug)->get() );
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
            // $products = Product::whereIn('id', $product_ids)->where( 'status', '=', 'published' )->get();
            $query = Product::whereIn('id', $product_ids)->where( 'status', '=', 'published' );
        }
        else {
            $query = Product::whereHas( 'categories', function ( $query ) use ( $queryParam ) {
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
            } );
        }
        $title = $qry;

        if($request->has('brand') ||  $request->has('size') || $request->has('colour') ||  $request->has('maxprice') || $request->has('minprice') ||$request->has('sort') ){

            if ($request->has('brand')) {
                $brands = Brand::whereIn('slug', $request->brand)->pluck('id')->toArray();
                // $products = $products->whereIn('brand_id', $brands);
                $query->whereIn('brand_id', $brands);
            }
            if ($request->has('size')) {
                $size = ProductAdditional::whereIn('size', $request->size)->pluck('product_id')->toArray();
                // $products = $products->whereIn('id', $size);
                $query->whereIn('id', $size);
            }
            if ($request->has('colour')) {
                // $products = $products->whereIn('color', $request->colour);
                $query->whereIn('color', $request->colour);
            }
            if ($request->has('minprice') && $request->has('maxprice') ) {
                $min=$request->minprice;
                $max=$request->maxprice;
                if(isset($min) && isset($max)){
                    // $products = $products->where('sale_price', '>=', $request->minprice)->where('sale_price', '<=', $request->maxprice);
                    $query->whereBetween('sale_price', [$request->minprice, $request->maxprice]);
                }
            }

            if($request->has('sort') ){
                $sortBy=$request->sort;

                if(isset($sortBy)){
                    if ($sortBy == 'popular') {
                        // $products = $products->sortByDesc('view');
                        $query->orderBy('view', 'desc');
                    }
                    if ($sortBy == 'new') {
                        // $products = $products->sortByDesc('created_at');
                        $query->orderBy('created_at', 'desc');
                    }
                    if ($sortBy == 'old') {
                        // $products = $products->sortBy('created_at');
                        $query->orderBy('created_at', 'asc');
                    }
                    if ($sortBy == 'a-z') {
                        // $products = $products->sortBy('name');
                        $query->orderBy('name', 'asc');
                    }
                    if ($sortBy == 'z-a') {
                        // $products = $products->sortByDesc('name');
                        $query->orderBy('name', 'desc');
                    }
                    if ($sortBy == 'high-low') {
                        // $products = $products->sortByDesc('sale_price');
                        $query->orderBy('sale_price', 'desc');
                    }
                    if ($sortBy == 'low-high') {
                        // $products = $products->sortBy('sale_price');
                        $query->orderBy('sale_price', 'asc');
                    }
                }
            }
            $products = $query->paginate(20);

            if($products->isNotEmpty()) {
                foreach ($products as $product) {

                    if($product->images->isNotEmpty()) {
                        foreach ($product->images as $image) {
                            $images[] = $image->path;
                        }
                    }
                    else {
                        $images = '';
                    }

                    $product->href = ['link' => route('api.products.show', $product->id)];
                    $product->imgs = $images;
                    $product->specifications;
                    $product->features;
                    $product->ratings = getRatings($product->id);
                    unset($product->images);
                    unset($images);
                }
            }

            // $products = $this->paginateHelper( $products, 20 );

            $data = [
                'data' => $products
            ];

            return response()->json($data, Response::HTTP_OK);
        }
        
        if (!empty($category)) {

            $categories = addRelation( Category::where('slug', $category->slug)->get() );
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
            $products = Product::whereIn('id', $product_ids)->where( 'status', '=', 'published' )->paginate(20);
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
            } )->paginate(20);
        }
        
        if($products->isNotEmpty()) {
            foreach ($products as $product) {
                $brand[] = Brand::where('id', $product->brand_id)->first();
                $product_id[] = $product->brand_id;

                if($product->images->isNotEmpty()) {
                    foreach ($product->images as $image) {
                        $images[] = $image->path;
                    }
                }
                else {
                    $images = '';
                }

                $product->href = ['link' => route('api.products.show', $product->id)];
                $product->imgs = $images;
                $product->specifications;
                $product->features;
                $product->ratings = getRatings($product->id);
                unset($product->images);
                unset($images);
            }
            if (!empty($product_id)) {
                $product_ids = array_unique($product_id);
            }
            $brands = Brand::whereIn('id', $product_ids)->get();

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
                    foreach($siz as $s){
                        $si[]=$s;
                    }
                    $collect = collect($si);
                    $size = $collect->unique();
                    $size->values()->all();
                }
            }
            if(isset($size)) {
                foreach ($size as $value) {
                    $sizes[] = $value->size;
                }
            }
            else {
                $sizes = [];
            }

            if (empty($colour)) {
                $colour = '';
            }
            if (empty($sizes)) {
                $sizes = [];
            }
        }
        else 
        {
            $brands = [];
            $colour = [];
            $sizes = [];
        }

        // $products = $this->paginateHelper( $products, 20 );

        $data = [
            'products' => $products,
            'brands' => $brands,
            'colors' => $colour,
            'sizes' => $sizes,
            'title' => $title
        ];

        return response()->json($data, Response::HTTP_OK);
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
