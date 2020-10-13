<?php

namespace App\Repositories\Eloquent;

use App\Model\Media;
use App\Model\Slideshow;
use App\Repositories\Contracts\SlideshowRepository;
use Illuminate\Support\Facades\Storage;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentSlideshowRepository extends AbstractRepository implements SlideshowRepository
{
    public function entity()
    {
        return Slideshow::class;
    }
    public function store(array $attributes)
    {
        if($attributes['image']) 
        {
                $images = $attributes['image'];
                $name = Storage::disk('public')->putFile('slideshow', $images);
                
                $filename= basename($name);
                $attributes['image'] ='/slideshow'.'/'.$filename;
        }
        $slideshow = $this->entity->create( $attributes );

        return $slideshow;
    }

    public function updateSlideshow($id, array $attributes)
    {
        $slideshow = $this->entity->findOrFail($id);

        // Upload image
        if($attributes['image']) 
        {
            $images = $attributes['image'];
            if($slideshow->image)
            {
                Storage::disk('public')->delete($slideshow->image);
            }
            $name = Storage::disk('public')->putFile('slideshow', $images);
            $filename= basename($name);
            $attributes['image'] ='/slideshow'.'/'.$filename;    
        }
        $slideshow->update( $attributes );

        return $slideshow;
    }

    public function deleteSlideshow($id)
    {
        $slideshow = $this->entity->find( $id );

        // Delete image
        Storage::disk('public')->delete($slideshow->image);

        $slideshow->delete();
        return true;
    }
}
