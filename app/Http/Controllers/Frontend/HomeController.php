<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Advertise;
use App\Model\Brand;
use App\Model\Coupon;
use App\Model\Deal;
use App\Model\Order;
use App\Model\Product;
use App\Model\Seo;
use App\Model\Slideshow;
use App\Model\VendorDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $slideshows = Slideshow::where('status', '=', 1)->orderBy('id', 'DESC')->take(5)->get();
        $brands = Brand::where('status', 1)->take('10')->get();
        $seos = Seo::where('status', 1)->get();
        $advertises = Advertise::where('status', 2)->take(10)->get();

        return view('front.index', compact('slideshows', 'brands', 'seos', 'advertises'));
    }

    public function single($id)
    {
        $products = Product::findOrFail($id);
        return view('front.single', compact('products'));
    }

    public function quickView($id)
    {
        $product = Product::findOrFail($id);
        $colours = $product->additionals->pluck('color')->toArray();
        $sizes = $product->additionals->pluck('size')->toArray();
        $shop = VendorDetail::where('user_id', $product->user_id)->first();
        $shop_name = $shop ? $shop->name : 'NA';

        return view('front.quick_view', compact('product', 'sizes', 'colours', 'shop_name'));
    }

    public function matchCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon)->first();
        if (empty($coupon)) {
            return redirect()->back()->with(['error' => 'This coupon is not valid for this product.']);
        } else {
            $date = Carbon::now()->format('Y-m-d');
            if ($coupon->uses_per_coupon != 0 && $coupon->end_date >= $date) {
                $coupon_user = DB::table('coupon_user')->where('user_id', auth()->id())->where('coupon_id', $coupon->id)->first();
                if (empty($coupon_user)) {
                    $coupon->uses_per_coupon = $coupon->uses_per_coupon - 1;
                    $coupon->update();
                    DB::table('coupon_user')->insert(['coupon_id' => $coupon->id, 'user_id' => auth()->id()]);
                    return $coupon;
                } else {
                    return 'This coupon is already been used.';
                }
            } else {
                return redirect()->back()->with(['error' => 'This coupon is not valid for this product.']);
            }
        }
    }

    public function checkTrack(Request $request)
    {
        $order = Order::where('code', $request->order_code)->first();
        return view('front.track_order', compact('order'));
    }

    public function getTrack(){
        return view('front.track_order');
    }

    public function aboutUs(){
        return view('front.about_us');
    }
    public function vendorHelp(){
        return view('front.vendor_help');
    }

}
