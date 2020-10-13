<?php

namespace App\Model;

use App\Concern\Mediable;
use App\Model\Product;
use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Sluggable,  Mediable;
    
    protected $fillable = [
        'user_id',
        'name',
        'company_name',
        'slug',
        'document',
        'description',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
