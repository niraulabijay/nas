<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Model\VendorDetail;
use App\Repositories\Contracts\VendorRepository;
use Illuminate\Http\Request;

class VendorDetailController extends Controller
{
    private $detailRepo;

    public function __construct(VendorRepository $detailRepo)
    {
    	$this->detailRepo = $detailRepo;
    }

    public function postStore(Request $request)
    {
        // dd($request);
        $this->detailRepo->store($request->except('_token'));

        return redirect()->back();
    }

    public function postUpdate($id, Request $request)
    {
        $this->detailRepo->update($id, $request->all());
 
        return redirect()->back();
    }

}
