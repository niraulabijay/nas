<?php

namespace App\Helpers\Image;

use File;

class LocalImageFile {

	public $relativePath = null;

	public $url = null;

	public function __construct( $relativePath = null ) {

		$this->relativePath = $relativePath;
		$this->url= asset( $relativePath );

		$sizes = config( 'image.sizes' );

		foreach ( $sizes as $sizeName => $widthHeight ) {
			$objectVarName = $sizeName . "Url";

			$baseName     = basename( $relativePath );
			$sizeNamePath = str_replace( $baseName, $sizeName . "-" . $baseName, $relativePath );

			$this->$objectVarName = asset( $sizeNamePath );
		}

	}


	/**
	 * @return $this
	 */
	public function destroy() {

		$sizes = config( 'image.sizes' );

		foreach ( $sizes as $sizeName => $widthHeight ) {
			$baseName     = basename( $this->relativePath );
			$sizeNamePath = str_replace( $baseName, $sizeName . "-" . $baseName, $this->relativePath );

			$path = public_path( $sizeNamePath );
			File::delete( $path );

		}

		$path = public_path( $this->relativePath );
		File::delete( $path );

		return $this;
	}

	public function getRelativePath() {
		return str_replace( asset( '/' ), '', $this->relativePath );
	}

}