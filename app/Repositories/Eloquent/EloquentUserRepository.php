<?php

namespace App\Repositories\Eloquent;

use App\Helpers\Image\LocalImageFile;
use App\Model\Media;
use App\Repositories\Contracts\UserRepository;
use App\User;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentUserRepository extends AbstractRepository implements UserRepository
{
    public function entity()
    {
        return User::class;
    }

    public function vendorDetailsStore(array $attributes)
    {
    	$attributes['user_id']=auth()->id();
//    	dd($attributes);
    	$this->vendorDetails()->create(['name' => $attributes['name']]);
    }

    public function getVendorDetails()
    {
    	$this->entity->vendorDetails()->all();
    }

    public function updateVendorDetails( $id, array $attributes ) {
        // $vendor_details = $this->entity->vendorDetails()->findOrFail( $id );
        // dd($vendor_details);
        // Upload image
        // if ( isset( $attributes['image'] ) ) {
        //     // Delete old image from file system
        //     $path = optional($brand->media()->first())->path;
        //     $this->deleteImage( $path );

        //     // Clean database links
        //     $brand->media()->delete();

        //     // Upload new image
        //     $media = new Media();
        //     $media->upload( $brand, $attributes['image'], '/uploads/brands/' );
        // }

        // $vendor_details->vendorDetails()->update( $attributes );

        // return $vendor_details;
    }

    public function getByRole( $role ) {
        $users = User::whereHas( 'roles', function ( $q ) use ( $role ) {
            $q->where( 'name', $role );
        } )->get();

        return $users;
    }

    public function getVisitors() {
        $users = User::whereDoesntHave( 'roles', function ( $q ) {
            $q->where( 'name', 'admin' );
            $q->orWhere( 'name', 'manager' );
            $q->orWhere( 'name', 'vendor' );
        } )->get();

        return $users;
    }

    public function store( array $attributes ) {
        $attributes['password'] = bcrypt( $attributes['password'] );

        $user = $this->entity->create( $attributes );

        //Attach role
        if ( $attributes['role'] != 0 ) {
            $user->roles()->attach( $attributes['role'] );
        }
        if ( isset( $attributes['image'] ) ) {
            $media = new Media();
            $media->upload( $user, $attributes['image'], '/uploads/users/' );
        }

        return $user;
    }

    public function updateUser( $id, array $attributes ) {
        $user = $this->find( $id );

        if ( isset( $attributes['image'] ) ) {
            // Delete old image from file system
            $path = optional($user->media()->first())->path;
            $this->deleteImage( $path );

            // Clean database links
            $user->media()->delete();

            // Upload new image
            $media = new Media();
            $media->upload( $user, $attributes['image'], '/uploads/users/' );
        }
        $user->user_name  = $attributes['user_name'];
        $user->first_name = $attributes['first_name'];
        $user->last_name  = $attributes['last_name'];
        $user->email      = $attributes['email'];
        $user->phone      = $attributes['phone'];

        if ( isset( $attributes['password'] ) ) {
            $user->password = bcrypt( $attributes['password'] );
        }

        $user->update();
        
        if(isset($attributes['destination']))
        {
            $user->delivery_boys()->updateOrCreate([
                    'user_id' => $user->id],[
                    'delivery_destination_id' => $attributes['destination']
                ]);
        }

        // Update role
        if ( $attributes['role'] != 0 ) {
            $user->roles()->sync( [ $attributes['role'] ] );
        } else {
            $user->roles()->detach();
        }

        return $user;
    }

    public function deleteUser( $id ) {

        $user = $this->find( $id );

        $path = optional($user->media()->first())->path;

        $this->deleteImage( $path );

        // Clean image database links
        $user->media()->delete();

        // Detach roles
        $user->roles()->detach();
        // Delete prices

        // Delete product
        $user->delete();

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
