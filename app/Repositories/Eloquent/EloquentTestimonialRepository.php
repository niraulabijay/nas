<?php

namespace App\Repositories\Eloquent;

use App\Helpers\Image\LocalImageFile;
use App\Model\Media;
use App\Model\Testimonial;
use App\Repositories\Contracts\TestimonialRepository;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentTestimonialRepository extends AbstractRepository implements TestimonialRepository
{
    public function entity()
    {
        return Testimonial::class;
    }

    public function store(array $attributes)
    {
    	$testimonials = $this->entity->create($attributes);

    	// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
	        try {
				$media = new Media();
				$media->upload( $testimonials, $attributes['featured_image'], '/uploads/testimonials/' );
	            return $attributes['featured_image'];
	            return $testimonials;
	        } catch (Exception $e) {
	            return $e;
	        }
	    }
    }

    public function updateTestimonial($id, array $attributes)
    {
    	$testimonial = $this->entity->findOrFail($id);

    	// Upload image
        if ( isset( $attributes['featured_image'] ) ) {
            // Delete old image from file system
            $path = optional($testimonial->media()->first())->path;
            $this->deleteImage( $path );

            // Clean database links
            $testimonial->media()->delete();

            // Upload new image
            $media = new Media();
            $media->upload( $testimonial, $attributes['featured_image'], '/uploads/testimonials/' );
        }

        $testimonial->update( $attributes );

        return $testimonial;
    }

    public function deleteTestimonial($id)
    {
    	$testimonial = $this->entity->find( $id );

        // Delete image
        $path = optional($testimonial->media()->first())->path;
        $this->deleteImage( $path );

        // Clean image database links
        $testimonial->media()->delete();

        $testimonial->delete();
        return true;
    }

    public function deleteImage($path)
    {
    	if ( null === $path ) {
            return false;
        }

        $localImageFile = new LocalImageFile( $path );
        $localImageFile->destroy();
        return true;
    }
}
