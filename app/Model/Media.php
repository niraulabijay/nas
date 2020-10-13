<?php

namespace App\Model;

use App\Helpers\Image\ImageService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
		'path',
		'original_filename',
		'mime_type',
		'mediable_id',
		'mediable_type'
	];

	/**
	 * Get all of the owning mediable models.
	 */
	public function mediable() {
		return $this->morphTo();
	}

	/**
	 * Upload file
	 *
	 * @param $model
	 * @param $attributes
	 * @param $path
	 *
	 * @return Media
	 */
	public function upload( $model, $attributes, $path ) {
		$relativePath = $path . Carbon::today()->format( 'Y/m/d' );

		$dbPath = $relativePath . '/' . $attributes->getClientOriginalName();

		$imageService = new ImageService();
		$imageService->upload( $attributes, $relativePath );

		$media                    = new Media();
		$media->path              = $dbPath;
		$media->original_filename = $attributes->getClientOriginalName();
		$media->mime_type         = $attributes->getMimeType();

		$model->media()->save( $media );

		return $media;
	}
}
