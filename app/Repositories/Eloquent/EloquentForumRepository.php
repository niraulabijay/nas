<?php

namespace App\Repositories\Eloquent;

use App\Forum;

use App\Repositories\Contracts\ForumRepository;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentForumRepository extends AbstractRepository implements ForumRepository
{
    public function entity()
    {
        return Forum::class;
    }
}
