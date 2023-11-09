<?php

namespace Codehunger\Blog;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(base_path('packages/codehunger/blog/src/Routes/web.php'));
        $this->loadMigrationsFrom(base_path('packages/codehunger/blog/src/Database/Migrations'));
        $this->loadViewsFrom(base_path('packages/codehunger/blog/src/Resources/views'), 'blog');
    }

    public function register()
    {
    }
}
