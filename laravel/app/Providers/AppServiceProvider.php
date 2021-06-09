<?php

namespace App\Providers;

use App\Models\MuseumNews;
use App\Models\MuseumPost;
use App\Observers\NewsObserver;
use App\Observers\PostsObserver;
use Illuminate\Support\ServiceProvider;

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
        MuseumNews::observe(NewsObserver::class);
        MuseumPost::observe(PostsObserver::class);
    }
}
