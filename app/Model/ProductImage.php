<?php

namespace App\Model;

use App\Helpers\Image\LocalImageFile;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'path',
        'is_main_image',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function getPathAttribute() {
        if ( null === $this->attributes['path'] || empty( $this->attributes['path'] ) ) {
            return null;
        }
        $localImage = new LocalImageFile( $this->attributes['path'] );

        return $localImage;
    }
}
