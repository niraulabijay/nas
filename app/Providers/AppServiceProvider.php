<?php

namespace App\Providers;

use App\Repositories\Contracts\BrandRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\ForumAnswerRepository;
use App\Repositories\Contracts\ForumRepository;
use App\Repositories\Contracts\OrderRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\ProductRepository;
use App\Repositories\Contracts\SlideshowRepository;
use App\Repositories\Contracts\TeamRepository;
use App\Repositories\Contracts\TestimonialRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\VendorRepository;
use App\Repositories\Eloquent\EloquentBrandRepository;
use App\Repositories\Eloquent\EloquentCategoryRepository;
use App\Repositories\Eloquent\EloquentForumAnswerRepository;
use App\Repositories\Eloquent\EloquentForumRepository;
use App\Repositories\Eloquent\EloquentOrderRepository;
use App\Repositories\Eloquent\EloquentPageRepository;
use App\Repositories\Eloquent\EloquentProductRepository;
use App\Repositories\Eloquent\EloquentSlideshowRepository;
use App\Repositories\Eloquent\EloquentTeamRepository;
use App\Repositories\Eloquent\EloquentTestimonialRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\Eloquent\EloquentVendorRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $throttleRate = config('mail.throttleToMessagesPerMin');
        if ($throttleRate) {
            $throttlerPlugin = new \Swift_Plugins_ThrottlerPlugin($throttleRate, \Swift_Plugins_ThrottlerPlugin::MESSAGES_PER_MINUTE);
            Mail::getSwiftMailer()->registerPlugin($throttlerPlugin);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->singleton( BrandRepository::class, EloquentBrandRepository::class );
        $this->app->singleton( CategoryRepository::class, EloquentCategoryRepository::class );
        $this->app->singleton( SlideshowRepository::class, EloquentSlideshowRepository::class );
        $this->app->singleton( ForumRepository::class, EloquentForumRepository::class );
        $this->app->singleton( ForumAnswerRepository::class, EloquentForumAnswerRepository::class );
        $this->app->singleton( ProductRepository::class, EloquentProductRepository::class );
        $this->app->singleton( TeamRepository::class, EloquentTeamRepository::class );
        $this->app->singleton( TestimonialRepository::class, EloquentTestimonialRepository::class );
        $this->app->singleton( UserRepository::class, EloquentUserRepository::class );
        $this->app->singleton( OrderRepository::class, EloquentOrderRepository::class );
        $this->app->singleton( VendorRepository::class, EloquentVendorRepository::class );
         $this->app->singleton( PageRepository::class, EloquentPageRepository::class );

    }
}
