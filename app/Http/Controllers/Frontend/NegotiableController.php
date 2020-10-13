<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Negotaible;
use App\Model\NegotiablePrice;
use App\Model\Product;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NegotiableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $negotiable = Negotaible::where('id',$id)->first();
        $last = NegotiablePrice::where('negotiable_id', $negotiable->id)->where('user_id', auth()->id())->orderBy('id', 'DESC')->first();
        if(!empty($last))
        {
            $last_date = Carbon::parse($last->updated_at);
            $result = $last_date->diffInDays(Carbon::now(), false);
        }

        return view('front.my_account.negotiate',compact('negotiable', 'result'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id)
    {
        $nego_product = Negotaible::where('product_id',$product_id)->where('user_id',auth()->id())->first();
//        dd($nego_product);
        if($nego_product){
            return redirect()->back()->with('error', 'Negotiable Alredy been Added');

        }
        $new= new Negotaible();
        $new->product_id = $product_id;
        $new->user_id= auth()->id();
        $new->save();
        return redirect()->route('user.account')->with('success', 'Negotiable has been Added');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $negotiable = Negotaible::findorfail($id);

        $negotiable1 = NegotiablePrice::where('negotiable_id',$negotiable->id)->get();
        foreach($negotiable1 as $row) {
            $row->active = 0;
            $row->update();
        }
        $message = $request->message;

        $negotiable -> negotiableMessages()->create( [
            'negotiable_id' => $negotiable->id,
            'message' => $message,
            'user_id' => auth()->id(),
            'active'  => 1
        ] );

//        $negotiable1 = DisputeMessage::where('dispute_id',$dispute->id)->get();




        return redirect()->back()->with('success','Message Sucessfully Sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function reload(Request $request)
    {



        $negotiate_product = NegotiablePrice::where('negotiable_id',$request->id)->where('active',1)->first();
//        foreach($dispute as $row) {
//            $row->active = 0;
//            $row->save();
//        }
        dd($negotiate_product);
        return view('front.my_account.reload', compact('negotiate_product'));
//        if(Auth::user()->hasRole(['admin','vendor']))
//        {
//            return view('admin.disputes.reload', compact('dispute'));
//        }
//        else
//        {
//            return view('front.disputes.reload', compact('dispute'));
//        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $negotiable = Negotaible::find($id);
        if($negotiable->delete()){
            return redirect()->back()->with('success', 'Negotiable has been Deleted');
        }

        return redirect()->back()->with('error', 'Error while Deleting');
    }
    public function checkout($id){
      $neg=Negotaible::findorfail($id);
      if($neg->user_id==auth()->id() && $neg->fixed_price){
	Cart::add([
                            'id' => $neg->product_id,
                            'name' => Product::findorfail($neg->product_id)->first()->name,
                            'qty' => 1,
                            'price' => $neg->fixed_price,
                        
                               
                        ]);
		return redirect()->route('checkout');

      }
      else{
          return redirect()->back();
      }
         
      } 
    
   
}
