<?php

namespace App\Repositories\Eloquent;

use App\Helpers\Image\LocalImageFile;
use App\Model\Media;
use App\Model\Team;
use App\Repositories\Contracts\TeamRepository;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentTeamRepository extends AbstractRepository implements TeamRepository
{
    public function entity()
    {
        return Team::class;
    }

    public function store(array $attributes)
    {
    	$teams = $this->entity->create($attributes);

    	// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
	        try {
				$media = new Media();
				$media->upload( $teams, $attributes['featured_image'], '/uploads/teams/' );
	            return $attributes['featured_image'];
	            return $teams;
	        } catch (Exception $e) {
	            return $e;
	        }
	    }
    }

    public function updateTeam($id, array $attributes)
    {
    	$team = $this->entity->findOrFail( $id );
        // Upload image
        if ( isset( $attributes['featured_image'] ) ) {
            // Delete old image from file system
            $path = optional($team->media()->first())->path;
            $this->deleteImage( $path );

            // Clean database links
            $team->media()->delete();

            // Upload new image
            $media = new Media();
            $media->upload( $team, $attributes['featured_image'], '/uploads/teams/' );
        }

        $team->update( $attributes );

        return $team;
    }

    public function deleteTeam($id)
    {
    	$team = $this->entity->find( $id );

        // Delete image
        $path = optional($team->media()->first())->path;
        $this->deleteImage( $path );

        // Clean image database links
        $team->media()->delete();

        $team->delete();
        return true;
    }

    public function deleteImage($path)
    {
    	if ( null === $path ) {
            return false;
        }

        $localImageFile = new LocalImageFile( $path );
        $localImageFile->destroy();
        return true;
    }
}
