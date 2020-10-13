<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Model\Area;
use App\Model\Package;
use App\Model\Type;
use Illuminate\Http\Request;

class MultiController extends Controller
{
    public function getType()
    {
        $types = Type::all();
    	return view('merchant.type.index')->withTypes($types);
    }
    public function getCreateType()
    {
    	return view('merchant.type.create');
    }
    public function postStoreType(Request $request)
    {
    	$this->validate($request,[
    		'type' => 'required',
    		'size' => 'required'
    	]);

    	$type = new Type;

    	$type->type = $request->type;
    	$type->size = $request->size;

    	$type->save();

    	return redirect()->back();

    }
    public function getEditType($id)
    {
        $type = Type::find($id);
        return view('merchant.type.edit',compact('type'));
    }

    public function updateType(Request $request,$id)
    {
        $this->validate($request,[
            'type' => 'required',
            'size' => 'required'
        ]);

        $type = Type::find($id);

        $type->type = $request->type;
        $type->size = $request->size;
        $type->save();

        return redirect()->back();
    }
    public function destroyType($id)
    {
        Type::where('id',$id)->delete();

        return redirect()->back();
    }

    public function getPackage()
    {
        $packages = Package::all();
    	return view('merchant.package.index')->withPackages($packages);
    }
    public function getCreatePackage()
    {
    	return view('merchant.package.create');
    }
    public function postStorePackage(Request $request)
    {
    	$this->validate($request,[
    		'period' => 'required'
    	]);

    	$package = new Package;

    	$package->period = $request->period;

    	$package->save();

    	return redirect()->back();
    }
    public function getEditPackage($id)
    {
        $package = Package::find($id);
        // dd($package);
        return view('merchant.package.edit',compact('package'));
    }
    public function updatePackage(Request $request,$id)
    {
        $this->validate($request,[
            'period' => 'required'
        ]);

        $package = Package::find($id);

        $package->period = $request->period;
        $package->save();

        return redirect()->back();
    }
    public function destroyPackage($id)
    {
        Package::where('id',$id)->delete();

        return redirect()->back();
    }

    public function getArea()
    {
        $areas = Area::all();
    	return view('merchant.area.index')->withAreas($areas);
    }
    public function getCreateArea()
    {
    	return view('merchant.area.create');
    }
    public function postStoreArea(Request $request)
    {
    	$this->validate($request,[
    		'area' => 'required'
    	]);

    	$area = new Area;

    	$area->area = $request->area;

    	$area->save();

    	return redirect()->back();
    }
    public function getEditArea($id)
    {
        $area = Area::find($id);
        // dd($area);
        return view('merchant.area.edit',compact('area'));
    }
    public function updateArea(Request $request,$id)
    {
        // dd($request);
        $this->validate($request,[
            'area' => 'required'
        ]);

        $area = Area::find($id);

        $area->area = $request->area;
        $area->save();

        return redirect()->back();
    }
    public function destroyArea($id)
    {
        Area::where('id',$id)->delete();

        return redirect()->back();
    }
}
