<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/2/2017
 * Time: 9:04 PM
 */

namespace App\Repositories\Contracts;


interface PageRepository {
	public function getAll();

	public function getById( $id );

	public function create( array $attributes );

	public function update( $id, array $attributes );

	public function delete( $id );
}