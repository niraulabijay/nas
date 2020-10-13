<?php

namespace App\Http\Controllers;

use App\Model\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function getIndex()
    {
    	return view('contact_view');
    }

    public function getCreate()
    {
    	return view('contact');
    }

    public function getStore(Request $request)
    {
$request->validate([
  'name'=>'required',
      'email'=>'required|email',
  'phone'=>'required',
  'subject'=>'required',
  'phone'=>'required|integer',
  'msg'=>'required',

]);   
$contact = new Contact;
    	$contact->name = $request->name;
    	$contact->email = $request->email;
    	$contact->subject = $request->subject;
    	$contact->phone = $request->phone;
    	$contact->message = $request->msg;

    	$contact->save();
    	    $data = [

        'name'=>$request['name'],

        'email'=>$request['email'],
        'subject'=>$request['subject'],
        'message'=>$request['msg'],

        'phone'=>$request['phone']
    ];

if(getConfiguration('order_email')){

    Mail::to(getConfiguration('order_email'))->send(new \App\Mail\Contact($data));
}
    Mail::to($request['email'])->send(new \App\Mail\ContactUser($data));

    	Session::flash('success',"Thanks for messaging us.");

    	return redirect()->back();
    }

    public function getView($id)
    {
    	$detail = Contact::findOrFail($id);
    	$detail->status = 1;
    	$detail->update();
    	return view('contact_details',compact('detail'));
    }

    public function sendEmail($id)
    {
        $detail = Contact::findOrFail($id);
        return view('contact_email',compact('detail'));
    }

    public function deleteMessage($id)
    {
    	Contact::where('id',$id)->delete();
    	Session::flash('success',"1 message is deleted!!!");
    	return redirect()->back();
    }

    public function makeAllRead()
    {
        $status = DB::table('contacts')->where('status', '=', 0)->update(array('status' => 1));
        return redirect()->back();
    }

    public function getContactsJson()
    {
        $contacts = Contact::all();
        return datatables( $contacts )->toJson();
    }

}
