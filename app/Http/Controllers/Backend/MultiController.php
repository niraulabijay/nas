<?php

namespace App\Http\Controllers\Backend;

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
    	return view('admin.type.index')->withTypes($types);
    }
    public function getCreateType()
    {
    	return view('admin.type.create');
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

    	return redirect()->back()->with('success', 'Type Successfully Added');

    }
    public function getEditType($id)
    {
        $type = Type::find($id);
        return view('admin.type.edit',compact('type'));
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

        return redirect()->back()->with('success', 'Type Successfully Updated');
    }
    public function destroyType($id)
    {
        Type::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Type Successfully Deleted');
    }

    public function getPackage()
    {
        $packages = Package::all();
    	return view('admin.package.index')->withPackages($packages);
    }
    public function getCreatePackage()
    {
    	return view('admin.package.create');
    }
    public function postStorePackage(Request $request)
    {
    	$this->validate($request,[
    		'period' => 'required'
    	]);

    	$package = new Package;

    	$package->period = $request->period;

    	$package->save();

    	return redirect()->back()->with('success', 'Package Successfully Added');
    }
    public function getEditPackage($id)
    {
        $package = Package::find($id);
        return view('admin.package.edit',compact('package'));
    }
    public function updatePackage(Request $request,$id)
    {
        $this->validate($request,[
            'period' => 'required'
        ]);

        $package = Package::find($id);

        $package->period = $request->period;
        $package->save();

        return redirect()->back()->with('success', 'Package Successfully Updated');
    }
    public function destroyPackage($id)
    {
        Package::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Package Successfully Deleted');
    }

    public function getArea()
    {
        $areas = Area::all();
    	return view('admin.area.index')->withAreas($areas);
    }
    public function getCreateArea()
    {
    	return view('admin.area.create');
    }
    public function postStoreArea(Request $request)
    {
    	$this->validate($request,[
    		'area' => 'required'
    	]);

    	$area = new Area;

    	$area->area = $request->area;

    	$area->save();

    	return redirect()->back()->with('success', 'Area Successfully Added');
    }
    public function getEditArea($id)
    {
        $area = Area::find($id);
        // dd($area);
        return view('admin.area.edit',compact('area'));
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

        return redirect()->back()->with('success', 'Area Successfully Updated');
    }
    public function destroyArea($id)
    {
        Area::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Area Successfully Deleted');
    }
}
