<?php

namespace App\Model;

use App\Helpers\Image\LocalImageFile;
use App\Model\Deal;
use App\Model\ProductAdditional;
use App\Model\ProductFaq;
use App\Model\ProductFeature;
use App\Model\ProductImage;
use App\Model\ProductSeo;
use App\Model\ProductSpecifaction;
use App\Model\ReviewProduct;
use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Sluggable;
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
public function sluggable() {
        return [
            'slug' => [
                'source' => ['name']
            ]
        ];
    }

    protected $fillable = [
        'name',
        'approved',
        'product_price',
        'sale_price',
        'negotiable',
        'quality',
        'tax',
        'sku',
        'stock_quantity',
        'stock',
        'long_description',
        'short_description',
        'brand_id',
        'user_id',
        'negotiable',
        'quality',
        'from',
        'to',
        'commission',
        'status',
        'view',
        'main',
        'color',
        'prebooking'
    ];



    public function features(){
        return $this->hasMany(ProductFeature::class);
    }

    public function faqs(){
        return $this->hasMany(ProductFaq::class);
    }

    public function seos(){
        return $this->hasMany(ProductSeo::class);
    }

    public function specifications(){
        return $this->hasMany(ProductSpecifaction::class);
    }

    public function additionals(){
        return $this->hasMany(ProductAdditional::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function brand() {
        return $this->belongsTo(Brand::class);
    }
    public function getImageAttribute() {
        $defaultPath = "/front/img/default-product.jpg";
        $image       = $this->images()->where( 'is_main_image', '=', 1 )->first();

        if ( null === $image ) {
            return new LocalImageFile( $defaultPath );
        }

        if ( $image->path instanceof LocalImageFile ) {
            return $image->path;
        }

    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function deals()
    {
        return $this->belongsToMany(Deal::class);
    }
    public function reviews()
    {
        return $this->hasMany(ReviewProduct::class);
    }
    public function getAverageRating()
    {
        return $this->reviews()->where('status',1)->avg('stars');
    }

    public function getDiscountPercentage()
    {

        $percentage = round( ( ( $this->product_price - $this->sale_price ) / $this->product_price ) * 100 );

        return $percentage;
    }
   
	public function getProductGallery() {
		$gallery = $this->images()->get();

		if ( null === $gallery ) {
			return null;
		}

		$galleryArray = [];

		foreach ( $gallery as $gal ) {
			$galleryArray[] = $gal->path;
		}

		return $galleryArray;
	}


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany( Order::class );
    }

    public function orderProduct() {
        return $this->hasMany( OrderProduct::class );
    }

    public function coupons()
    {
        return $this->belongsToMany( Coupon::class );
    }

    public function productRelation()
    {
        return $this->hasMany(ProductRelation::class, 'product_id');
    }

    public function relation()
    {
        return $this->hasOne(ProductRelation::class, 'relation_id');
    }
}
