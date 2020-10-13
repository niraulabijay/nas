<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorBankInfo extends Model
{
    protected $fillable = [
        'user_id','bank_name','account_holder','account_number'
    ];
}
