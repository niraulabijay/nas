<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\SlideshowRequest;
use App\Repositories\Contracts\SlideshowRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideshowController extends Controller
{
    private $slideshowRepository;

    public function __construct(SlideshowRepository $slideshowRepository)
    {
        $this->slideshowRepository = $slideshowRepository;
    }

    public function index()
    {
        return view('admin.slideshow.index');
    }

    public function create()
    {
        return view('admin.slideshow.create');
    }

    public function store(SlideshowRequest $request)
    {
        $this->slideshowRepository->store($request->all());
        return redirect()->back()->with('success', 'Slideshow Successfully Added');
    }

    public function getSlideshowJson()
    {
        $slideshows = $this->slideshowRepository->all();
        return datatables( $slideshows )->toJson();
    }

    public function delete($id)
    {
        $this->slideshowRepository->deleteSlideshow($id);
        return response()->json('Slideshow successfully deleted!');
    }

    public function editSlideshow($id)
    {
        $slideshow = $this->slideshowRepository->find($id);
        return view('admin.slideshow.edit', compact('slideshow'));
    }

    public function update($id, SlideshowRequest $request)
    {
        $this->slideshowRepository->updateSlideshow($id, $request->all());
        return redirect()->back()->with('success', 'Slideshow Successfully Updated');
    }

}
