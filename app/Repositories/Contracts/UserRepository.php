<?php

namespace App\Repositories\Contracts;

interface UserRepository
{
    public function vendorDetailsStore(array $attributes);
}
