<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            [ 'partials.header' ], 'App\Http\ViewComposers\MenuListComposer'
        );

        view()->composer(
            [
                'vendor.harimayco-menu.menu-html',
                'admin.layouts.app',
                'partials.header',
                'layouts.app',
                'partials.footer'

            ], 'App\Http\ViewComposers\ProductCategoryListComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
