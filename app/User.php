<?php

namespace App;

use App\Concern\Mediable;
use App\Events\UserRegistered;
use App\Model\Brand;
use App\Model\DeliveryBoy;
use App\Model\Dispute;
use App\Model\Forum;
use App\Model\ForumAnswer;
use App\Model\Like;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\Product;
use App\Model\Referal;
use App\Model\ReferalTransaction;
use App\Model\Referral;
use App\Model\Role;
use App\Model\ShippingAccount;
use App\Model\Vendor;
use App\Model\Wallet;
use App\Model\Wishlist;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, EntrustUserTrait, Mediable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'user_name',
        'first_name',
        'last_name',
        'phone',
        'token',
        'verified',
        'provider',
        'remember_token',
        'verified',
        'provider_id',
        'user_name',

    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'created' => UserRegistered::class,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function forums()
    {

        return $this->hasMany(Forum::class);
    }

    public function answers()
    {

        return $this->hasMany(ForumAnswer::class);
    }

    public function likes()
    {

        return $this->hasMany(Like::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function user_infos()
    {
        return $this->hasOne(User_info::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class);
    }

    public function vendorDetails()
    {
        return $this->hasOne(Vendor::class, 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany(ShippingAccount::class, 'user_id');
    }

    public function referral_code()
    {
        return $this->hasOne(Referal::class);
    }

    public function wallets()
    {
        return $this->hasOne(Wallet::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function delivery_boys()
    {
        return $this->belongsTo(DeliveryBoy::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

}

