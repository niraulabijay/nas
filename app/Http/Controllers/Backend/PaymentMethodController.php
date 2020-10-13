<?php

namespace App\Http\Controllers\Backend;

use App\Model\Media;
use App\Helpers\Image\LocalImageFile;
use App\Concern;
use App\Model\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = PaymentMethod::all();
        foreach ($payments as $payment) {
            $image = null !== $payment->getImage()?$payment->getImage()->smallUrl: $payment->getDefaultImage()->smallUrl;
            $payment->image = $image;
        }
        return view('admin.payment.index',compact('payments','payment'));

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
        $this->validate($request, [
            'name' => 'required',
            'company_name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $payment = new PaymentMethod();
        $payment->name = $request->name;
        $payment->company_name = $request->company_name;
        $payment->save();
        if($request->hasFile('image'))
        {
            $media = new Media();
            $media->upload( $payment, $request->file('image'), '/uploads/payment/' );
        }

        return redirect()->back()->with('success', 'Payment Successfully Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = $payment = PaymentMethod::find($id);
        return view('admin.payment.edit',compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $id = $request->id;

        $paymentUpdate = PaymentMethod::find($id);
        $paymentUpdate->name = $request->name;
        $paymentUpdate->company_name = $request->company_name;
            if($request->hasFile('image'))
            {
                $path = optional($paymentUpdate->media()->first())->path;
                $this->deleteImage( $path );
                $paymentUpdate->media()->delete();
                $media = new Media();
                $media->upload( $paymentUpdate, $request->file('image'), '/uploads/payment/' );
            }


        $paymentUpdate->Update();
        return redirect()->route('admin.payment.index')->with('success','Paymenth updated Successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destory($id)
    {

        $payment = PaymentMethod::find($id);

        $path = optional($payment->media()->first())->path;

        $this->deleteImage( $path );

        // Clean image database links
        $payment->media()->delete();

        $payment->delete();
        return redirect()->back()->with('success', 'Paysment Successfully Deleted.');
    }


    public function deleteImage($path){
        if($path==null){
            return false;

        }
        $localImageFile= new LocalImageFile($path);
        $localImageFile->destroy();
        return true;
    }
}
