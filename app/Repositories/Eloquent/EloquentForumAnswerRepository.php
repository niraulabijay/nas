<?php

namespace App\Repositories\Eloquent;

use App\ForumAnswer;

use App\Repositories\Contracts\ForumAnswerRepository;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentForumAnswerRepository extends AbstractRepository implements ForumAnswerRepository
{
    public function entity()
    {
        return ForumAnswer::class;
    }
}
