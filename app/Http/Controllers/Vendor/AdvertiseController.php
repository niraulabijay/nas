<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Model\Advertise;
use App\Model\Area;
use App\Model\Package;
use App\Model\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $advertises = Advertise::where('user_id',auth()->id())->get();
        return view('merchant.advertise.index',compact('advertises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $types = Type::all();
        $packages = Package::all();
        $areas = Area::all();
        return view('merchant.advertise.create',compact('types','packages','areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);

        try
        {
            if($request->hasFile('image'))
            {
                $image = $request->file('image');
                // dd($image);
                $name = Storage::disk('public')->putFile('storage/advertise',$image);
                $filename= basename($name);
            }

            $advertise = new Advertise;
            $advertise->user_id = auth()->id();
            $advertise->title = $request->title;
            $advertise->image_type = $request->image_type;
            $advertise->advertise_area = $request->advertise_area;
            $advertise->package = $request->package;
            $advertise->image = 'advertise'. '/' .$filename;
            $advertise->status=1;
            $advertise->save();
        }
        catch (\Exception $e)
        {
            throw new \Exception('Error in saving advertise:' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Advertise Successfully Added');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advertise  $advertise
     * @return \Illuminate\Http\Response
     */
    public function getShow(Advertise $id)
    {
        $advertise = Advertise::where('id',$id)->first();
        return view('merchant.advertise.single',compact('advertise'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advertise  $advertise
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advertise = Advertise::findOrFail($id);
        $types = Type::all();
        $packages = Package::all();
        $areas = Area::all();
        return view('merchant.advertise.edit', compact('advertise', 'types', 'packages', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advertise  $advertise
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $advertise = Advertise::findOrFail($id);
        $this->validate($request,[
            'title' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);

        try
        {
            if($request->hasFile('image'))
            {
                $image = $request->file('image');
                if($advertise->image)
                {
                    Storage::disk('public')->delete($advertise->image);
                }

                $name = Storage::disk('public')->putFile('storage/advertise',$image);
                $filename= basename($name);
            $advertise->image = 'advertise'. '/' .$filename;
            }

            $advertise->user_id = auth()->id();
            $advertise->title = $request->title;
            $advertise->image_type = $request->image_type;
            $advertise->advertise_area = $request->advertise_area;
            $advertise->package = $request->package;
            $advertise->update();
        }
        catch (\Exception $e)
        {
            throw new \Exception('Error in updating advertise:'.$e->getMessage());
        }

        return redirect()->route('vendor.advertise.index')->with('success', 'Advertise Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advertise  $advertise
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertise = Advertise::findOrFail($id);
        if($advertise->image)
        {
            Storage::disk('public')->delete($advertise->image);
        }
        $advertise->delete();

        return redirect()->back()->with('success', 'Advertise Successfully Deleted');
    }
}
