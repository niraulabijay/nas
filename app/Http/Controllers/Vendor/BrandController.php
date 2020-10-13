<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BrandRepository;
use Kurt\Repoist\Repositories\Eloquent\Criteria\Completed;
use App\Model\Brand;
use App\Model\Media;
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
        return view('merchant.brand.index');
    }

    public function store(BrandRequest $request)
    {

       $slug= str_slug($request->name,'-');
        $dbSlug= Brand::where('slug',$slug)->first();

        if(isset($dbSlug)){
             return response()->json('! Brand already Exists');
        }
       else{
           $brand = new Brand();
       $brand->user_id = auth()->id();
       $brand->name = $request->name;
       $brand->company_name = $request->company_name;
       $brand->description = $request->description;
       if(!empty($request->file('document')))
       {
           $image = $request->file('document');
    
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        
            $destinationPath = public_path('/uploads/brands/documents');
        
            $image->move($destinationPath, $input['imagename']);
            $brand->document = $input['imagename'];
       }
        $brand->save();
        
       // Upload image
        if ( isset( $request->image ) ) {
            try {
                $media = new Media();
                $media->upload( $brand, $request->image, '/uploads/brands/' );
                // return $brand;
            } catch (Exception $e) {
                return $e;
            }
        }
        
       return response()->json('Brand Successfully Added');
       } 
       
    }

    public function delete($id)
    {
        $this->brandRepository->deleteBrand($id);
        return response()->json('Brand Successfully Deleted');
    }

    public function getBrandsJson()
    {
        $brands = Brand::where('user_id', auth()->id())->get();  
        foreach ($brands as $brand) {
                  $image = null !== $brand->getImage()? $brand->getImage()->smallUrl: $brand->getDefaultImage()->smallUrl;
                  $brand->image = $image;
              }      
        return datatables( $brands )->toJson();
    }

    public function editBrand($id)
    {
        $brands = $this->brandRepository->find($id);
        return view('merchant.brand.edit', compact('brands'));
    }

    public function updateBrand(BrandRequest $request)
    {
        $this->brandRepository->updateBrand($request->id, $request->all());
        return response()->json('Brand Successfully Updated');
    }
}
