<?php

namespace App\Http\Controllers\Backend;

use App\Model\VendorDetail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorRequest;
use App\Model\VendorDocument;



class VendorRequestController extends Controller
{
    public  function index()
    {
       $requests=VendorDetail::where('verified',0)->get();
       return view('admin.request_vendors',compact('requests'));
    }

    public function accept(Request $request)
    {
      $request=VendorDetail::findorfail($request->id);
      $request->verified=1;
      $request->update();
    //   $user=User::findorfail($request->user_id);
    //   $role=\App\Model\Role::where('name','vendor')->first()->id;
    //   $user->roles()->sync( $role);

      $data=[
          'name'=>$request->name,
          'status'=>'Accepted'
      ];
       Mail::to($request->primary_email)->send(new VendorRequest($data));
       return redirect()->back()->with('success','Status Changed SucessFully');

    }

 public function reject(Request $request)
    {
      $request=VendorDetail::findorfail($request->id);
      $data=[
          'name'=>$request->name,
          'status'=>'Rejected'
      ];

       Mail::to($request->primary_email)->send(new VendorRequest($data));
      return redirect()->back()->with('success','Status Changed SucessFully');
    }

    public function  delete(Request $request)
    {
           $request=VendorDetail::findorfail($request->id);
//        $doc=VendorDocument::where('vendor_detail_id',$request->id)->get();
//        $doc->delete();
        $user=User::findorfail($request->user_id);
        $role=\App\Model\Role::where('name','vendor')->first()->id;
        $user->roles()->detach( $role);

                 foreach (VendorDocument::where('vendor_detail_id',$request->id)->get() as $doc){
             $doc->delete();
         }
           $request->delete();
           return redirect()->back()->with('success','Deleted sucessfully');
    }


    public function view($id)
    {
        $request=VendorDetail::findorfail($id);
        return view('admin.request_view',compact('request'));
    }
}
