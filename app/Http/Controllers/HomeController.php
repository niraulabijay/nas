<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Model\Coupon;
use App\Model\CouponProduct;
use App\Model\OrderProduct;
use App\Model\Referal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function referalCheck(Request $request)
    {
        $val = $request->text;

        if (getConfiguration('active') == 0) {
            return response()->json(['status' => 'error', 'message' => 'Referal service is disabled'], 401);
        }
        $referal = Referal::where('referal_code', $val)->first();

        if ($referal) {
            return response()->json('Your referral code is valid');
        } else {
            return response()->json(['status' => 'error', 'message' => 'Your referral code is invalid'], 401);
        }
    }

    public function couponCheck(Request $request)
    {

        $val = $request->input('coupon_code');
        if(session()->exists('coupon'))
        {
            return redirect()->back()->with('success', 'Coupon has already applied!');
        }
        if ($val != null) {
            $coupon = Coupon::where('code', $val)->first();
            if (!$coupon) {
                return redirect()->back()->with('error', 'Coupon Does not exist!');

            }
            else
            {
                if(OrderProduct::where('coupon_id',$coupon->id)->get()->count() >= $coupon->uses_per_coupon )
                {
                    return redirect()->back()->with('error', 'Coupon Maximum Limit Exceeded!');

                }
                if(Carbon::now()->toDateString() < $coupon->start_date )
                {
                    return redirect()->back()->with('error', 'Coupon Not Started Yet!');

                }
                if(Carbon::now()->toDateString() > $coupon->end_date )
                {
                    return redirect()->back()->with('error', 'Coupon Expired!');

                }
                $coupon_product=CouponProduct::where('coupon_id',$coupon->id)->whereIn('product_id',$request->product_id)->get();
                if($coupon_product->count() > 0)
                {
                    session()->put('coupon', [
                        'id' => $coupon->id,
                        'product_id' => $coupon_product->first()->product_id,
                        'code' => $coupon->code,
                        'discount_value' => $coupon->discount_value
                    ]);
                    return redirect()->back()->with('success', 'Your Coupon code is valid.' .' You got Discount of Rs'.$coupon->discount_value.'!');

                }
                else
                {
                    return redirect()->back()->with('error', 'This Coupon Does not Applied to This Product!');
                }

            }
        } 
        else 
        {
            return redirect()->back()->with('error', 'Field is empty!');

        }

    }

    public function ppcGenerate(Request $request)
    {
        if (auth()->guest()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login to generate your code!!'
            ], 401);
        }
            $user=Auth::user();
            $code= $request->url().'/'.$user->token;
                 return response()->json($code);
        }


    public function verify($token)    {

        $user = User::where('token', $token)->first();
        if(isset($user)){
            if($user->verified==1){
                return view('emailconfirm', ['message' => 'Your Account is Already Verified !']);
            }
            else{
                $user->verified=1;
                $user->update();
                return view('emailconfirm', [
                        'message' => 'Your Account is Verified Successfully',
                        'success'=>'success']
                );
            }
        }
        else{
            return view('emailconfirm', ['message' => 'Invalid  Token !!!']);
        }
    }

    public function resendMail($id)
    {
        $user = User::where('id', $id)->first();

        $data = [
            'email_token'=>$user->token
        ];

        Mail::to($user->email)->send(new EmailVerification($data));

        return redirect()->back()->with('success', 'Email is successfully sent. Please check your inbox!');
    }
}
