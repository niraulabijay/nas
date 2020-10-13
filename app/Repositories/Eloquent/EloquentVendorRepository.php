<?php

namespace App\Repositories\Eloquent;

use App\Model\Vendor;
use App\Repositories\Contracts\VendorRepository;

use Illuminate\Support\Facades\Storage;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentVendorRepository extends AbstractRepository implements VendorRepository
{
    public function entity()
    {
        return Vendor::class;
    }

    public function vendorDetailsStore(array $attributes)
    {
       
        $attributes['user_id'] = auth()->id();
        $details = $this->entity->updateOrCreate(['user_id'=>$attributes['user_id']], $attributes);

       

        // $details->seos()->updateOrCreate(['vendor_detail_id' => $attributes['vendor_id']],[
        //     'bank_account' => $attributes['bank_account'],
        //     'bank_account_number' => $attributes['bank_account_number'],
        // ]);

//        $details->type()->updateOrCreate([
//            'category' => $attributes['category']
//        ]);
        if (isset($attributes['category'])) {
            $details->type = json_encode($attributes['category']);
            $details->update();
            }else{
                $details->type = null;
                $details->update();
        }

        return $details;
    }
}
