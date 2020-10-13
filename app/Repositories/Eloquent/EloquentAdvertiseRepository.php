<?php

namespace App\Repositories\Eloquent;

use App\Model\Advertise;
use App\Repositories\Contracts\AdvertiseRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentAdvertiseRepository extends AbstractRepository implements AdvertiseRepository
{
    public function entity()
    {
        return Advertise::class;
    }

    public function store(array $attributes)
    {
    	$advertise = $this->entity->create($attributes);
    	// Upload Image

    }
    public function update($id, array $attributes)
    {
    	$brand = $this->entity->findOrFail($id);
    	// upload image
    	return $brand;
    }
}
