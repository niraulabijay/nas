<?php

namespace App\Http\Controllers\Backend;

use App\Model\Negotaible;
use App\Model\NegotiablePrice;
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
    public function index()
    {
        $negotiables = Negotaible::all();

       return view('admin.negotiable.negotiable',compact('negotiables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function priceUpdate(Request $request, $id){

        $priceUpdate = Negotaible::where('id', $id)->update([
            'fixed_price'=>$request->input('fixed_price')
        ]);

        if($priceUpdate){
            return redirect()->back()->with('success','Price Sucessfully Update');
        }


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
        $negotiable = Negotaible::where('id',$id)->first();

        return view('admin.negotiable.index',compact('negotiable'));
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
        //
    }
}
