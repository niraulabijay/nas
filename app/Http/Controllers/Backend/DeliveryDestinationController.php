<?php

namespace App\Http\Controllers\Backend;

use App\Model\DeliveryDestination;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryDestinationController extends Controller
{
    public function index()
    {
        $destinations = DeliveryDestination::all();
        // $orders = Order::where('delivery_destination_id', $destinations->id)->count();
//        $payments = PaymentMethod::all();
//        foreach ($payments as $payment) {
//            $image = null !== $payment->getImage()?$payment->getImage()->smallUrl: $payment->getDefaultImage()->smallUrl;
//            $payment->image = $image;
//        }
        return view('admin.destination.index',compact('destinations','$orders'));

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $destination = new DeliveryDestination();
        $destination->name = $request->name;
        $destination->remark = $request->remark;
        $destination->save();


        return redirect()->back()->with('success', 'Destination Successfully Created.');
    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
    public function edit($id)
    {
        $destination = DeliveryDestination::find($id);
        return view('admin.destination.edit',compact('destination'));
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
    public function update(Request $request)
    {

        $id = $request->id;

        $destination = DeliveryDestination::find($id);
        $destination->name = $request->name;
        $destination->remark = $request->remark;


        $destination->Update();
        return redirect()->route('admin.delivery.index')->with('success','Delivery Destination updated Successfully');


    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
    public function destory($id)
    {

        $payment = DeliveryDestination::find($id);

        $payment->delete();
        return redirect()->back()->with('success', 'Delivery Destination Successfully Deleted.');
    }

//
//
}
