<?php

namespace App\Http\Controllers\Backend;

use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\OrderReturnRequest;
use App\Model\Product;
use App\Model\Vendor;
use App\Model\VendorDocument;



use App\Model\ReviewProduct;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Support\Facades\Storage;


class VendorStatController extends Controller
{
     public function getConfiguration($id)
    {
        $vendor = Vendor::where('user_id', $id)->first();

        return view('admin.vendor_details', compact('vendor','id'));
    }
     public function saveDetails(Request $request,$id)
    {

        $request->vendor_code = 'NAS'.$id.rand(0,9);
       $vendor= Vendor::updateOrCreate(['user_id'=>$id],$request->only(['name','type','address','primary_email','secondary_email','primary_
        phone','secondary_phone','description','pan_number','tax_clearance', 'vendor_code']));
        $vendor->seos()->updateOrCreate(['vendor_detail_id'=>$vendor->id],$request->only(['seo_keywords','seo_description']));
                $vendor->socials()->updateOrCreate(['vendor_detail_id'=>$vendor->id],$request->only(['facebook_url','google_url','twitter_url','instagram_url']));
                        if($request->pan_image){
            $pan=VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','pan_image')->first();
            if($pan)
            {


             $test=$pan->image;
           File::delete($test);
                $pan->delete();

            }
            $images = $request['pan_image'];

            $name = Storage::disk('public')->putFile('documents', $images);

            $filename= basename($name);
            $vendorDocument=new VendorDocument();
$vendorDocument->vendor_detail_id=$vendor->id;
            $vendorDocument->title='pan_image';
            $vendorDocument->image ='documents'.'/'.$filename;
$vendorDocument->save();

        }
         if($request->company_image){
            $com=VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','company_image')->first();

            if($com)
            {
                $test=$com->image;
                File::delete($test);
            }
            $vendorDocument=new VendorDocument();
            $images = $request['company_image'];


            $name = Storage::disk('public')->putFile('documents', $images);
            $filename= basename($name);
            $vendorDocument->vendor_detail_id=$vendor->id;

            $vendorDocument->title='company_image';
            $vendorDocument->image ='documents'.'/'.$filename;
            $vendorDocument->save();
        }
        if($request->signature_image){
            $sig=VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','signature_image')->first();
            if($sig)
            {$test=$sig->image;
                File::delete($test);
            }
            $images = $request['signature_image'];


            $name = Storage::disk('public')->putFile('documents', $images);
            $filename= basename($name);
            $vendorDocument=new VendorDocument();
            $vendorDocument->vendor_detail_id=$vendor->id;

            $vendorDocument->title='signature_image';
            $vendorDocument->image ='documents'.'/'.$filename;
            $vendorDocument->save();
        }


 return redirect()->back()->with('success','SucessFully Changed');
     }
    
    
    public function index($name, $id, Request $request)
    {
        switch ($name) {
            case 'brands':
                $brand = Brand::findorfail($id);
                $id = $brand->id;
                $name = $request['name'];
                $title = 'Brands-'.$brand->user_name;
                $productsCount = $brand->products()->count();
                break;
            case 'category':
                $category = Category::findorfail($id);
                $id = $category->id;
                $name = $request['name'];
                $title = 'Category-'.$category->user_name;
                $productsCount = $category->products()->count();
                break;
            case 'deals':
                $deal = Deal::findorfail($id);
                $id = $deal->id;
                $name = $request['name'];
                $title = 'Deals-'.$deal->user_name;
                $productsCount = $deal->products()->count();
                break;
            case 'vendor':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $productsCount = Product::where('user_id', $vendor->id)->count();
                break;
            case 'approved':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $productsCount = Product::where('user_id', $vendor->id)->where('approved',1)->count();
                break;
            case 'pending':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $productsCount = Product::where('user_id', $vendor->id)->where('approved',0)->count();
                break;
            case 'reviews':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $productsCount = ReviewProduct::whereHas('products', function ($query) use ($vendor) {
                    $query->where('user_id', $vendor->id);
                })->get();
                break;
            default:

                break;
        }
        return view('admin.vendors.table', compact('title','productsCount','name','id'));
    }

    public function getCustomProductsJson(Request $request)
    {
        $name  = $request->input( 'name' );
        $id = $request->input( 'id' );
        switch ($name) {
            case 'brands':
                $brand = Brand::findorfail($id);
                $products = $brand->products()->get();
                break;
            case 'category':
                $category = Category::findorfail($id);
                $products = $category->products()->get();
                break;
            case 'deals':
                $deal = Deal::findorfail($id);
                $products = $deal->products()->get();
                break;
            case 'vendor':
                $vendor = User::findorfail($id);
                $products = Product::where('user_id', $vendor->id)->get();
                break;
            case 'approved':
                $vendor = User::findorfail($id);
                $products = Product::where('user_id', $vendor->id)->where('approved',1)->get();
                break;
            case 'pending':
                $vendor = User::findorfail($id);
                $products = Product::where('user_id', $vendor->id)->where('approved',0)->get();
                break;
            case 'reviews':
                $vendor = User::findorfail($id);
                $products = ReviewProduct::whereHas('products', function ($query) use ($vendor) {
                    $query->where('user_id', $vendor->id);
                })->get();
                break;
            default:

                break;
        }
        return datatables($products)->toJson();
    }

    public function getOrderStat($name, $id, Request $request)
    {
        switch ($name) {
            case 'all':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id);
                })->count();
                break;
            case 'approved':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                    ->where('status', 2);
                })->count();
                break;
            case 'pending':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 1);
                })->count();
                break;
            case 'received':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 3);
                })->count();
                break;
            case 'delivered':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 4);
                })->count();
                break;
            case 'cancelled':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 5);
                })->count();
                break;
            case 'review':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 6);
                })->count();
                break;
            default:

                break;
        }

        return view('admin.vendors.order_stat', compact('title','ordersCount','name','id'));
    }

    public function getOrderStatJson(Request $request)
    {
        $name  = $request->input( 'name' );
        $id = $request->input( 'id' );
        switch ($name) {
            case 'all':
                $vendor = User::findorfail($id);
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id);
                })->get();
                break;
            case 'approved':
                $vendor = User::findorfail($id);
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                    ->where('status', 2);
                })->get();
                break;
            case 'pending':
                $vendor = User::findorfail($id);
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 1);
                })->get();
                break;
            case 'received':
                $vendor = User::findorfail($id);
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 3);
                })->get();
                break;
            case 'delivered':
                $vendor = User::findorfail($id);
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 4);
                })->get();
                break;
            case 'cancelled':
                $vendor = User::findorfail($id);
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 5);
                })->get();
                break;
            case 'review':
                $vendor = User::findorfail($id);
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 6);
                })->get();
                break;
            default:

                break;
        }

        if (null === $orders) {
            return datatables($orders)->toJson();
        }

        $ordersArray = [];
        foreach ($orders as $orderKey => $orderValue) {
            $ordersArray[$orderKey]['id'] = $orderValue->id;
            $ordersArray[$orderKey]['order_status'] = $orderValue->orderStatus->name;
            $ordersArray[$orderKey]['order_date'] = Carbon::parse($orderValue->order_date)->format('d/m/Y');
            $ordersArray[$orderKey]['userOrder'] = [
                'order_id' => $orderValue->id,
                'user_id' => $orderValue->user_id,
                'user_first_name' => isset($orderValue->user->first_name) ? $orderValue->user->user_name : '',
                'user_email' => isset($orderValue->user->email) ? $orderValue->user->email : '',
            ];

            $ordersArray[$orderKey]['address'] = [
                'address_first_name' => isset($orderValue->shipping_address->first_name) ? $orderValue->shipping_address->first_name : null,
                'address_last_name' => isset($orderValue->shipping_address->last_name) ? $orderValue->shipping_address->last_name : null,
                'address_landmark' => isset($orderValue->shipping_address->landmark) ? $orderValue->shipping_address->landmark : null,
                'address_street_name' => isset($orderValue->shipping_address->street_name) ? $orderValue->shipping_address->street_name : null,
                'address_city' => isset($orderValue->shipping_address->city) ? $orderValue->shipping_address->city : null,
                'address_landline' => isset($orderValue->shipping_address->landline) ? $orderValue->shipping_address->landline : null,
                'address_phone' => isset($orderValue->shipping_address->mobile) ? $orderValue->shipping_address->mobile : null,
            ];


            $priceTotal = 0;

            foreach ($orderValue->products as $productKey => $productValue) {
                $ordersArray[$orderKey]['products'][$productKey] = [
                    'name' => $productValue->name,
                    'product_id' => $productValue->pivot->product_id,
                    'order_id' => $productValue->pivot->order_id,
                    'qty' => $productValue->pivot->qty,
                    'price' => $productValue->pivot->price,
                    'discount' => $productValue->pivot->discount,
                    'tax_amount' => $productValue->pivot->tax_amount,
                ];

                $actualPrice = $productValue->pivot->qty * $productValue->pivot->price;
                $actualPrice += $actualPrice * ($productValue->pivot->tax / 100);
                $dis = $productValue->pivot->discount;
                $priceTotal += ($actualPrice - $dis);
            }

            if ($orderValue->shipping_amount) {
                $priceTotal += $orderValue->shipping_amount;
            }

            $ordersArray[ $orderKey ]['price_total'] = number_format($priceTotal, 2);


        }

        return datatables($ordersArray)->toJson();
    }

    public function getOrderReturnStat($name, $id, Request $request)
    {
        switch ($name) {
            case 'all':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $orderReturnsCount = OrderReturnRequest::whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->count();
                break;
            case 'approved':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $orderReturnsCount = OrderReturnRequest::where('status_id', 2)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->count();
                break;
            case 'pending':
                $vendor = User::findorfail($id);
                $id = $vendor->id;
                $name = $request['name'];
                $title = 'Vendor-'.$vendor->user_name;
                $orderReturnsCount = OrderReturnRequest::where('status_id', 1)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->count();
                break;
            default:

                break;
        }

        return view('admin.vendors.order_return_stat', compact('title','orderReturnsCount','name','id'));
    }

    public function getOrderReturnStatJson(Request $request)
    {
        $name  = $request->input( 'name' );
        $id = $request->input( 'id' );
        switch ($name) {
            case 'all':
                $vendor = User::findorfail($id);
                $order_returns = OrderReturnRequest::whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->get();
                break;
            case 'approved':
                $vendor = User::findorfail($id);
                $order_returns = OrderReturnRequest::where('status_id', 2)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->get();
                break;
            case 'pending':
                $vendor = User::findorfail($id);
                $order_returns = OrderReturnRequest::where('status_id', 1)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->get();
                break;
            default:

                break;
        }

        $orderReturnArray = [];

        foreach ( $order_returns as $orderReturnKey => $orderReturnValue ) {
            $orderReturnArray[$orderReturnKey]['id'] = $orderReturnValue->id;

            $orderReturnArray[$orderReturnKey]['userOrder'] = [
                'order_id' => $orderReturnValue->orderReturnProducts->first()->order_product->order_id,
                'user_id' => $orderReturnValue->user_id,
                'username' => isset($orderReturnValue->users->user_name) ? $orderReturnValue->users->user_name : '',
                'email' => isset($orderReturnValue->users->email) ? $orderReturnValue->users->email : ''
            ];

            $orderReturnArray[$orderReturnKey]['order_return_status'] = [
                'status' => $orderReturnValue->orderReturnStatus->name,
                'class' => getOrderReturnStatusClass($orderReturnValue->orderReturnStatus->name)
            ];
            $orderReturnArray[$orderReturnKey]['order_date'] = Carbon::parse($orderReturnValue->created_at)->format('d/m/Y');

            $orderReturnArray[$orderReturnKey]['address'] = [
                'address_first_name' => isset($orderReturnValue->users->addresses->first()->first_name) ? $orderReturnValue->users->addresses->first()->first_name : null,
                'address_last_name' => isset($orderReturnValue->users->addresses->first()->last_name) ? $orderReturnValue->users->addresses->first()->last_name : null,
                'address_street_name' => isset($orderReturnValue->users->addresses->first()->street_name) ? $orderReturnValue->users->addresses->first()->street_name : null,
                'address_landmark' => isset($orderReturnValue->users->addresses->first()->landmark) ? $orderReturnValue->users->addresses->first()->landmark : null,
                'address_location_type' => isset($orderReturnValue->users->addresses->first()->location_type) ? $orderReturnValue->users->addresses->first()->location_type : null,
                'address_city' => isset($orderReturnValue->users->addresses->first()->city) ? $orderReturnValue->users->addresses->first()->city : null,
                'address_country_id' => isset($orderReturnValue->users->addresses->first()->country) ? $orderReturnValue->users->addresses->first()->country : null,
                'address_mobile' => isset($orderReturnValue->users->addresses->first()->mobile) ? $orderReturnValue->users->addresses->first()->mobile : null,
                'address_landline' => isset($orderReturnValue->users->addresses->first()->landline) ? $orderReturnValue->users->addresses->first()->landline : null,
            ];


            $orderReturnArray[ $orderReturnKey ]['products'] = [
                'name' => $orderReturnValue->orderReturnProducts->first()->order_product->products->name,
                'product_id'   => $orderReturnValue->orderReturnProducts->first()->order_product->product_id,
                'order_id'     => $orderReturnValue->orderReturnProducts->first()->order_product->order_id,
                'qty'          => $orderReturnValue->orderReturnProducts->first()->qty,
                'price'        => $orderReturnValue->orderReturnProducts->first()->order_product->price,
            ];

        }

        return datatables( $orderReturnArray )->toJson();
    }
}
