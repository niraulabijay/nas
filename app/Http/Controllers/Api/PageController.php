<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Contact;
use App\Mail\ContactUser;
use App\Model\Contact as Message;
use App\Model\Order;
use App\Model\RequestProduct;
use App\Model\VendorDetail;
use App\Model\VendorDocument;
use App\Repositories\Contracts\VendorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
	private $vendorRepository;

    public function __construct(VendorRepository $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function getAbout()
    {
    	$history = getConfiguration('who_we_are');
        $mission = getConfiguration('our_mission');

        $about = [
            'about' => [
                'history' => $history,
                'mission' => $mission
            ]
        ];

        return response()->json($about, Response::HTTP_OK);
    }

    public function getContact()
    {
        $address = getConfiguration('site_address');
        $email = getConfiguration('site_primary_email');
        $phone = getConfiguration('site_primary_phone');

        $contact_info = [
            'contact_info' => [
                'address' => $address,
                'email' => $email,
                'phone' => $phone
            ],
            'socials' => [
            	'facebook_link' => getConfiguration('facebook_link'),
            	'instagram_link' => getConfiguration('instagram_link'),
            	'youtube_link' => getConfiguration('youtube_link'),
            	'twitter_link' => getConfiguration('twitter_link')
            ]
        ];
 
        return response()->json($contact_info, Response::HTTP_OK);
    }

    public function storeContact(Request $request)
    {
    	$validator = Validator::make($request->all(), [
          	'name'=>'required',
          	'email'=>'required|email',
          	'subject'=>'required',
          	'phone'=>'required|integer',
          	'msg'=>'required',
        ]);  

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }

        $contact = new Message();
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

        if(getConfiguration('order_email'))
        {
            Mail::to(getConfiguration('order_email'))->send(new \App\Mail\Contact($data));
        }                   
        Mail::to($request['email'])->send(new \App\Mail\ContactUser($data));

        return response()->json(['msg' => 'Your message is sent successfully!'], Response::HTTP_CREATED);
    }

    public function storeSellWithUs(Request $request)
    {
    	$validator = Validator::make($request->all(), [
		    'name' => 'required|unique:vendor_details,user_id,' . auth()->id(),
		    'pan_number' => 'required|integer',
	        'email' => 'required|email',
	        'tax_clearance'=>'required',
		    'type' => 'required',
		    'address' => 'required',
		    'phone' => 'required',
		    'pan_image'=>'image|required',
		    'company_image'=>'image',
		    'signature_image' => 'image'
		]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }
        
        if(VendorDetail::where('user_id',auth()->id())->count()>0)
        {
            $new = VendorDetail::where('user_id',auth()->id())->first();
            
            if(VendorDocument::where('vendor_detail_id',$new->id)->where('title','pan_image')->count()>0)
            {
                $pan_image=VendorDocument::where('vendor_detail_id',$new->id)->where('title','pan_image')->first();
            }
            else
            {
                $pan_image=new VendorDocument();
            }
            if(VendorDocument::where('vendor_detail_id',$new->id)->where('title','company_image')->count()>0)
            {
                $company_image=VendorDocument::where('vendor_detail_id',$new->id)->where('title','company_image')->first();
            }
            else
            {
                $company_image=new VendorDocument();  
            }
            if(VendorDocument::where('vendor_detail_id', $new->id)->where('title', 'signature_image')->count() > 0)
            {
                $signature_image = VendorDocument::where('vendor_detail_id', $new->id)->where('title', 'signature_image')->first();
            }
            else
            {
                $signature_image = new VendorDocument();
            }
        }
        
        else
        {
            $new=new VendorDetail();
            $pan_image=new VendorDocument();
            $company_image=new VendorDocument();
            $signature_image = new VendorDocument();
        }

        $new->user_id=auth()->id();
        $new->name=$request->name;
        $new->pan_number=$request->pan_number;
        $new->primary_email=$request->email;
        $new->type=$request->type;
        $new->tax_clearance=$request->tax_clearance;
        $new->address=$request->address;
        $new->primary_phone=$request->phone;
        $new->verified='0';
        $new->save(); 

        if($request->pan_image) 
        {
            $pan_image->vendor_detail_id=$new->id;
            $pan_image->title='pan_image';
            $pan_image->image = 'data:image/jpeg/png/gif;base64,' . base64_encode(file_get_contents($request->file('pan_image')));
            $pan_image->save();
        }
        if($request->company_image) 
        {
            $company_image->title='company_image';
            $company_image->vendor_detail_id=$new->id;

            $company_image->image = 'data:image/jpeg/png/gif;base64,' . base64_encode(file_get_contents($request->file('company_image')));
            $company_image->save();
        }
        if($request->signature_image) 
        {
            $signature_image->title = 'signature_image';
            $signature_image->vendor_detail_id = $new->id;

            $signature_image->image = 'data:image/jpeg/png/gif;base64,' . base64_encode(file_get_contents($request->file('signature_image')));
            $signature_image->save();
        }

        return response()->json(['success' => 'Vendor Request SucessFully Sent .Please Wait For Further Processing'], Response::HTTP_CREATED);
    }

    public function getPolicies()
    {
    	$privacy_policy = getConfiguration('privacy_policy');
    	$return_policy = getConfiguration('return_policy');
    	$terms_conditions = getConfiguration('terms_conditions');
    	$cancellation = getConfiguration('cancellation');
    	$payments = getConfiguration('payments');
    	$shipping = getConfiguration('shipping');

    	$data = [
    		'privacy_policy' => $privacy_policy,
    		'return_policy' => $return_policy,
    		'terms_conditions' => $terms_conditions,
    		'cancellation' => $cancellation,
    		'payments' => $payments,
    		'shipping' => $shipping
    	];

    	return response()->json($data, Response::HTTP_OK);
    }

    public function getAds()
    {
    	$ad1 = getConfiguration('category_ads_1');
    	$ad1_link = getConfiguration('category_ads_link_1');
    	$ad1_image = url('storage') . '/' . getConfiguration('category_ads_image_1');

    	$ad2 = getConfiguration('category_ads_2');
    	$ad2_link = getConfiguration('category_ads_link_2');
    	$ad2_image = url('storage') . '/' . getConfiguration('category_ads_image_2');

    	$ad3 = getConfiguration('category_ads_3');
    	$ad3_link = getConfiguration('category_ads_link_3');
    	$ad3_image = url('storage') . '/' . getConfiguration('category_ads_image_3');

    	$ad4 = getConfiguration('category_ads_4');
    	$ad4_link = getConfiguration('category_ads_link_4');
    	$ad4_image = url('storage') . '/' . getConfiguration('category_ads_image_4');

    	$data = [
    		'ad1' => [
    			'ad1_title' => $ad1,
    			'ad1_link' => $ad1_link,
    			'ad1_image' => $ad1_image
    		],
    		'ad2' => [
    			'ad2_title' => $ad2,
    			'ad2_link' => $ad2_link,
    			'ad2_image' => $ad2_image
    		],
    		'ad3' => [
    			'ad3_title' => $ad3,
    			'ad3_link' => $ad3_link,
    			'ad3_image' => $ad3_image
    		],
    		'ad4' => [
    			'ad4_title' => $ad4,
    			'ad4_link' => $ad4_link,
    			'ad4_image' => $ad4_image
    		]
    	];

    	return response()->json($data, Response::HTTP_OK);
    }

    public function trackOrder(Request $request)
    {
    	$order = Order::where('code', $request->order_code)->first();
    	if(isset($order))
    	{
	    	$one = 100 / 7;
	        switch($order->orderStatus->name) {
	            case 'pending':
	                $percent = $one;
	                break;
	            case 'received':
	                $percent = $one * 2;
	                break;
	            case 'approved':
	                $percent = $one * 4;
	                break;
	            case 'delivered':
	                $percent = $one * 6;
	                break;
	            case 'review':
	                $percent = $one * 3;
	                break;
	            case 'dispatched':
	                $percent = $one * 5;
	                break;
	            case 'completed':
	                $percent = $one * 7;
	                break;
	            default:
	                $percent = 0;
	        }
	    }
	    else
	    {
	    	return response()->json(['msg' => 'Invalid Order Number!'], Response::HTTP_NOT_FOUND);
	    }

        $data = [
        	'percent' => $percent,
        	'status' => $order->orderStatus->name
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    public function requestProduct(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'name' => 'required',
    		'email' => 'required|email',
    		'phone' => 'required|digits:10',
    		'title' => 'required',
    		'product_specification' => 'required'
    	]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }

    	$requests = new RequestProduct;
        $requests->user_id = auth()->id();
    	$requests->name = $request->name;
    	$requests->email = $request->email;
    	$requests->phone = $request->phone;
    	$requests->product_title = $request->title;
    	$requests->product_specification = $request->product_specification;
    	$requests->product_reference = $request->reference;
    	$requests->product_category = $request->category;
    	$requests->save();

    	return response()->json(['msg' => 'Thanks for sending request!'], Response::HTTP_CREATED);
    }
}
