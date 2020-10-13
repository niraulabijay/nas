<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/2/2017
 * Time: 9:05 PM
 */

namespace App\Repositories\Eloquent;


use App\Helpers\Image\LocalImageFile;
use App\Model\Media;
use App\Page;
use App\Repositories\Contracts\PageRepository;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentPageRepository extends AbstractRepository implements PageRepository{
	/**
	 * @var Page
	 */
	private $model;

	public function __construct( Page $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model->all();
	}

	public function getById( $id ) {
		return $this->model->findOrFail( $id );
	}

	public function create( array $attributes ) {
		$attributes['user_id'] = auth()->id();

		$page = $this->model->create( $attributes );

		// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
			$media = new Media();
			$media->upload( $page, $attributes['featured_image'], '/uploads/pages/' );
		}
		
		return $page;
	}

	public function update( $id, array $attributes ) {
		$page = $this->getById( $id );

		// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
			// Delete old image from file system
			$path = optional($page->media()->first())->path;
			$this->deleteImage( $path );

			// Clean database links
			$page->media()->delete();

			// Upload new image
			$media = new Media();
			$media->upload( $page, $attributes['featured_image'], '/uploads/pages/' );
		}

		$page->update( $attributes );

		return $page;
	}

	public function delete( $id ) {
		$page = $this->getById( $id );

		// Delete image
		$path = optional($page->media()->first())->path;
		$this->deleteImage( $path );

		// Clean image database links
		$page->media()->delete();

		$page->delete();

		return true;
	}

	public function deleteImage( $path ) {
		if ( null === $path ) {
			return false;
		}

		$localImageFile = new LocalImageFile( $path );
		$localImageFile->destroy();

		return true;
	}
}