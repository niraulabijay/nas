<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image\ImageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Jobs\StockNotify;
use App\Mail\AlertVendor;
use App\Mail\ProductAlert;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductAdditional;
use App\Model\ProductFaq;
use App\Model\ProductFeature;
use App\Model\ProductImage;
use App\Model\ProductRelation;
use App\Model\VendorDetail;
use App\Model\ProductSpecifaction;
use App\Repositories\Contracts\ProductRepository;
use App\User;
use App\Model\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Slim\Slim;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductCreate()
    {
        $products = Product::where('main', 1)->pluck('name', 'id')->toArray();

        return view('admin.products.existing', compact('products'));
    }

    public function create()
    {
        $brands = Brand::where('status', 1)->get();
        $categorys = Category::where('parent_id', 0)->get();
        $role = Role::where('name', 'vendor')->first();
        $vendors = $role->users;
        // dd($vendors);
        

        return view('admin.products.create', compact('brands', 'categorys', 'vendors'));
    }

    public function createExistingProduct(Request $request)
    {
        $request->validate(['product' => 'required']);

        $brands = Brand::where('status', 1)->get();
        $categorys = Category::where('parent_id', 0)->get();
        $existing = Product::where('id', $request->product)->first();
        $role = Role::where('name', 'vendor')->first();
        $vendors = $role->users;

        return view('admin.products.create', compact('brands', 'categorys', 'existing', 'vendors'));
    }

    public function index()
    {
        $all = Product::whereNotIn('status', ['deleted'])->count();
        $pending = Product::where('approved', 0)->whereNotIn('status', ['deleted'])->count();
        $approved = Product::where('approved', 1)->whereNotIn('status', ['deleted'])->count();
        $published = Product::where('status', 'published')->count();
        $unpublished = Product::where('status', 'unpublished')->count();
        $deleted = Product::where('status', 'deleted')->count();

        return view('admin.products.index', compact('all', 'pending', 'approved', 'published', 'unpublished', 'deleted'));
    }

    public function getProductsJson(Request $request)
    {
        switch ($request->status) {
            case 'approved':
                $products = Product::where('approved', 1)->whereNotIn('status', ['deleted'])->get();
                break;
            case 'pending':
                $products = Product::where('approved', 0)->whereNotIn('status', ['deleted'])->get();
                break;
            case 'published':
                $products = Product::where('status', 'published')->get();
                break;
            case 'unpublished':
                $products = Product::where('status', 'unpublished')->get();
                break;
            case 'deleted':
                $products = Product::where('status', 'deleted')->get();
                break;
            case 'all':
                $products = Product::whereNotIn('status', ['deleted'])->get();
                break;
        }
        
        foreach($products as $product){
            $shop= VendorDetail::where('user_id', $product->user_id)->first();
            $product->vendor_name = $shop ? $shop->name: 'Nepal All Shop';
            $product->vendor_id = $shop ? $shop->user_id: '';
        }

        return datatables($products)->toJson();
    }

    public function store(ProductRequest $request)
    {
        
        try {
            if(isset($request->existing))
            {
                $request['main'] = 0;
            }
            else
            {
                $request['main'] = 1;
            }
            
            // dd($request);

            $product = $this->productRepository->store($request->all());

            ProductRelation::create([
                    'product_id' => $request->existing ? $request->existing : $product->id,
                    'relation_id' => $product->id
                ]);
                
            $sendData = array
            (
                'body'  => 'New Product in NAS! Hurry Up!!',
                'title' => 'New Product in NAS',
                'icon'  => 'myicon',/*Default Icon*/
                'sound' => 'mySound',/*Default sound*/
                'image' => $product->getImageAttribute()->mediumUrl,
                'id' => $product->id,
            );
            $response = onesignalNotification($sendData);
        
            if(isset($request->existing))
            {
                return redirect()->route('admin.products.create')->with('success', 'Product Successfully Added.');
            }

        } catch (Exception $e) {

            throw new Exception('Error in saving product: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Product Successfully Added.');
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->update([
            'status' => 'deleted'
        ]);

        return redirect()->back()->with('success', 'Product moved to deleted.');
    }

    public function deleteAndRemove($id)
    {
        try {
            $this->productRepository->deleteProduct($id);
        } catch (Exception $e) {

            throw new Exception('Error in deleting product: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Product Successfully Deleted.');
    }

    public function getProductsJson2()
    {
        $user = Auth::User();
        $products = $user->products();

        return datatables($products)->toJson();
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $brands = Brand::where('status', 1)->get();
        $categories = Category::where('parent_id', 0)->get();
        $role = Role::where('name', 'vendor')->first();
        $vendors = $role->users;
        return view('admin.products.edit', compact('product', 'brands', 'categories', 'vendors'));
    }

    public function update(Request $request)
    {
        
        try {
            $oldApproved = Product::find($request->id);

            if ($oldApproved->approved == 0 && $request->approved == 1) {
                $this->productRepository->updateProducts($request->id, $request->all());
                $user = User::find($oldApproved->user_id);
                $emailData = [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'name' => $request->name,
                ];

                \Mail::to($user->email)->send(new AlertVendor($emailData));

            } else {
                $this->productRepository->updateProducts($request->id, $request->all());

            }

            if ($oldApproved->stock == 0 && $oldApproved->stock_quantity == 0 && $request->stock_quantity > 0) {
                StockNotify::dispatch($oldApproved)->delay(now()->addSeconds(5));
            }


        } catch (Exception $e) {

            throw new Exception('Error in updating product: ' . $e->getMessage());
        }
        return redirect()->route('admin.products.index', 'status=all')->with('success', 'Product Successfully Updated.');
    }

    public function table()
    {
        $user = Auth::User();
        $all = $user->products()->count();
        $pending = $user->products()->where('approved', 0)->count();
        $approved = $user->products()->where('approved', 1)->count();
        return view('admin.products.index', compact('all', 'pending', 'approved'));
    }

    public function uploadImage(Request $request)
    {
        $image = $request->file('image');
        $tmpPath = str_split(strtolower(str_random(3)));
        $checkDirectory = '/uploads/product/images/' . implode('/', $tmpPath);

        $dbPath = $checkDirectory . '/' . $image->getClientOriginalName();

        $imageService = new ImageService();
        $image = $imageService->upload($image, $checkDirectory);

        $tmp = $this->_getTmpString();
// dd($image);
        return view('admin.products.upload-image')
            ->with('image', $image)
            ->with('tmp', $tmp);
    }

    public function _getTmpString($length = 6)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    public function deleteImage(Request $request)
    {
        $collection = ProductImage::where('path', $request->input('path'))->get(['id']);
//dd($collection);
        ProductImage::destroy($collection->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Image successfully deleted.',
        ]);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function stock()
    {
        $user = auth()->id();
        $products = Product::where('user_id', $user)->paginate(10);
        return view('admin.products.stock_manager', compact('products'));
    }

    public function singleProduct($id)
    {
        $products = Product::findOrFail($id);
        $user = User::where('id', $products->user_id)->first();
        return view('admin.product', compact('products', 'user'));
    }

    public function searchProduct(Request $request)
    {
        $term = trim($request->input('q'));
        if (empty($term)) {
            return response()->json([], 200);
        }

        $products = Product::where('name', 'like', '%' . $term . '%')->orderBy('name')->take(15)->get();

        $formattedProducts = [];

        foreach ($products as $productKey => $productValue) {
            $formattedProducts[] = ['id' => $productValue->id, 'text' => $productValue->name];
        }

        return response()->json($formattedProducts, 200);

    }


    public function updateStatus($id){
        $product = Product::findOrFail($id);
        $product;
        if ($product->approved == '1') {
            $product->approved = '0';
        } else {
            $product->approved = '1';
        }
        $product->update();
        return response()->json('status updated');

    }

    public function deleteFaq( Request $request ) {
        $faq = ProductFaq::findOrFail( $request->input( 'faq' ) );

        $faq->delete();

        return response()->json( [
            'success' => true,
            'message' => 'Faq successfully deleted!!'
        ] );
    }

    public function deleteSpecification( Request $request ) {
        $specification = ProductSpecifaction::findOrFail( $request->input( 'specification' ) );

        $specification->delete();

        return response()->json( [
            'success' => true,
            'message' => 'Specification successfully deleted!!'
        ] );
    }

    public function deleteFeature( Request $request ) {
        $feature = ProductFeature::findOrFail( $request->input( 'feature' ) );

        $feature->delete();

        return response()->json( [
            'success' => true,
            'message' => 'Feature successfully deleted!!'
        ] );
    }

    public function deleteColor( Request $request ) {
        $color = ProductAdditional::findOrFail( $request->input( 'color' ) );

        $color->delete();

        return response()->json( [
            'success' => true,
            'message' => 'Color successfully deleted!!'
        ] );
    }
}
