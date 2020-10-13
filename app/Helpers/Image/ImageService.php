<?php

namespace App\Helpers\Image;

use File;
use Intervention\Image\ImageManager;
use Carbon\Carbon;

class ImageService extends ImageManager {

	public $image = null;

	public function upload( $image, $path = null, $keepAspectRation = true ) {
		$this->image = parent::make( $image );
		$this->directory( public_path( $path )  );
		
// 		dd($path);
		$testdate = Carbon::today()->format( 'Y/m/d');
        if($path == '/uploads/brands/'.$testdate || $path == '/uploads/payment/'.$testdate || $path == '/uploads/users/'.$testdate || $path == '/uploads/category/'.$testdate){
            $name = $image->getClientOriginalName();
        }else{
            $name = time().$image->getClientOriginalName();
        }


		$fullPath = public_path( $path ) . '/' . $name;

		$this->image->save( $fullPath );

		$sizes = config( 'image.sizes' );

		foreach ( $sizes as $sizeName => $widthHeight ) {

			list( $width, $height ) = $widthHeight;

			$image = parent::make( $fullPath );
			// Create new image with transparent background color
			$canvas = parent::canvas( $width, $height, array(255, 255, 255, 0) );
			// Read image file and resize it to 200x200
			// But keep aspect-ratio and do not size up,
			// So smaller sizes don't stretch
			$image->resize($width, $height, function($constraint)
			{
				$constraint->aspectRatio();
				$constraint->upsize();
			});

			// Insert resized image centered into background
			$canvas->insert($image, 'center');

			$sizePath = $image->dirname . '/' . $sizeName . "-" . $image->basename;
			$canvas->save( $sizePath );
		}

		$localImage = new LocalImageFile( $path . '/' . $name );

		return $localImage;
	}

	public function directory( $path ) {
		if ( ! File::exists( $path ) ) {
			File::makeDirectory( $path, 0755, true, true );
		}

		return $this;
	}

	public function destroy() {
		//
	}
}

