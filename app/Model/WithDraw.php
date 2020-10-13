<?php

namespace App\Model;

use App\Model\WithdrawStatus;
use App\User;
use Illuminate\Database\Eloquent\Model;

class WithDraw extends Model
{
    protected $fillable = [
    	'vendor_id',
    	'status',
    	'approve',
        'amount',
    	'bank_name',
    	'account_no',
    	'account_name',
    	'bank_branch',
    	'additional_references'
    ];

    protected $table ="with_draws";


    public function vendors()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }



    public function users()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

}
