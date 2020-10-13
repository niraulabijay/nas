<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BrandRepository;
use Kurt\Repoist\Repositories\Eloquent\Criteria\Completed;
use App\Model\Brand;
use App\Model\Product;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;


class BrandController extends Controller
{

    private $brandRepository;

    function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    
    {
       $products = Product::where('user_id', 232)->get();
       
        
        return view('admin.brand.index');
 
    }

    public function store(BrandRequest $request)
    {
       $this->brandRepository->store($request->all());
       return response()->json('Brand Sucessfullly Added');
    }

    public function delete($id)
    {
        $this->brandRepository->deleteBrand($id);
        return response()->json('Brand Sucessfullly Deleted');
    }

    public function getBrandsJson()
    {
        $brands = $this->brandRepository->all();  
        foreach ($brands as $brand) {
                  $image = null !== $brand->getImage()? $brand->getImage()->smallUrl: $brand->getDefaultImage()->smallUrl;
                  $brand->image = $image;
              }      
        return datatables( $brands )->toJson();
    }

    public function editBrand($id)
    {
        $brands = $this->brandRepository->find($id);
        return view('admin.brand.edit', compact('brands'));
    }

    public function updateBrand(BrandRequest $request)
    {
        $this->brandRepository->updateBrand($request->id, $request->all());
        return response()->json('Brand Sucessfullly Updated');
    }
}
