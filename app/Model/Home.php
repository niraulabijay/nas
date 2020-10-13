<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $fillable = [
    	'home_key',
    	'home_value'
    ];

    public static function getHome( $key ) {
		$model = new static();

		$row = $model->where( 'home_key', '=', $key )->first();
		if ( $row != null ) {
			return $row->home_value;
		}
	}
}
