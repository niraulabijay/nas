<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Repositories\Contracts\TestimonialRepository;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
	private $testimonial;

	public function __construct(TestimonialRepository $testimonial)
	{
		$this->testimonial = $testimonial;
	}

    public function index()
    {
    	return view('admin.testimonials.index');
    }

    public function create()
    {
    	return view('admin.testimonials.create');
    }

    public function store(TestimonialRequest $request)
    {
    	$this->testimonial->store($request->all());
    	return response()->json('Testimonial Successfully Added');
    }

    public function getTestimonialsJson()
    {
    	$testimonials = $this->testimonial->all();
        foreach ($testimonials as $testimonial) {
                  $image = null !== $testimonial->getImage()? $testimonial->getImage()->smallUrl: $testimonial->getDefaultImage()->smallUrl;
                  $testimonial->image = $image;
              }
    	return datatables($testimonials)->toJson();
    }

    public function edit($id)
    {
    	$testimonials = $this->testimonial->find($id);
    	return view('admin.testimonials.edit', compact('testimonials'));
    }

    public function update($id, TestimonialRequest $request)
    {
    	$this->testimonial->updateTestimonial($id, $request->all());
    	return response()->json('Testimonial Successfully Updated');
    }

    public function delete($id)
    {
        $this->testimonial->deleteTestimonial($id);
        return response()->json('Testimonial Successfully Deleted');
    }
}
