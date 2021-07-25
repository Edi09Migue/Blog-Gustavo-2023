<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Optix\Media\Facades\Conversion;
use Intervention\Image\Image;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Conversion::register('thumb', function (Image $image) {
            return $image->fit(64, 64);
        });

        Conversion::register('preview', function (Image $image) {
            return $image->fit(370, 370);
        });

        Conversion::register('square', function (Image $image) {
            return $image->fit(500, 500);
        });
    }
}