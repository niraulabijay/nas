<?php

namespace App\Concern;

use App\Helpers\Image\LocalImageFile;
use App\Model\Media;

trait Mediable {

	/**
	 * Get all of the resource's media.
	 */
	public function media() {
		return $this->morphMany( Media::class, 'mediable' );
	}

	/**
	 * Check if the resource has a media
	 * @return bool
	 * @internal param int $media_id
	 *
	 */
	public function hasImage() {
		return $this->media()->count() > 0 ? true : false;
	}

	public function getImage() {
		$image = $this->media()->first();

		if ( null === $image ) {
			return null;
		}

		return new LocalImageFile( $image->path );
	}

	public function getDefaultImage( $defaultPath = null ) {
		if ( $defaultPath == null ) {
			$defaultPath = "/img/default-product.jpg";
		}

		return new LocalImageFile( $defaultPath );
	}
}
