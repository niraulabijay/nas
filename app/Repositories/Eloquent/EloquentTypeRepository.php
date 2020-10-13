<?php

namespace App\Repositories\Eloquent;

use App\Type;
use Repositories\Contracts\TypeRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentTypeRepository extends AbstractRepository implements TypeRepository
{
    public function entity()
    {
        return Type::class;
    }
    public function store(array $attributes)
    {
    	$type = $this->entity->create($attributes);
    	// Upload Image

    }
}
