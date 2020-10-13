<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seos = Seo::all();
        return view('admin.seos.index', compact('seos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.seos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
            'link' => 'required'
        ]);

        $seo = new Seo();
        $seo->keyword = $request->keyword;
        $seo->link = $request->link;
        $seo->status = $request->status;
        $seo->save();

        return redirect()->back()->with('success', 'Keyword successfully saved for seo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seo = Seo::findOrFail($id);
        return view('admin.seos.edit', compact('seo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keyword' => 'required',
            'link' => 'required'
        ]);

        $seo = Seo::findOrFail($id);
        $seo->keyword = $request->keyword;
        $seo->link = $request->link;
        $seo->status = $request->status;
        $seo->update();

        return redirect()->route('admin.seo.index')->with('success', 'Keyword successfully updated for seo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seo = Seo::findOrFail($id);
        $seo->delete();

        return redirect()->back()->with('success', 'Keyword successfully deleted for seo!');
    }

    public function getSeoJson()
    {
        $seos = Seo::all();
        return datatables($seos)->toJson();
    }
}
