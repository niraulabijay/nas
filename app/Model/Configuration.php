<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
		'configuration_key',
		'configuration_value',
	];

	public static function getConfiguration( $key ) {
		$model = new static();

		$row = $model->where( 'configuration_key', '=', $key )->first();
		if ( $row != null ) {
			return $row->configuration_value;
		}
	}
}
