<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Category;
use App\Tag;

class ComposerViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer(
            ['frontend.blog-section.blog-layout'],
            function ($view) {
                $categories = Category::where('status', 1)->has('blogs')->take(10)->get();
                $view->with('categories', $categories);
            }
        );

        view()->composer(
            ['frontend.blog-section.blog-layout'],
            function ($view) {
                $tags = Tag::where('status', 1)->has('blogs')->take(10)->get();
                $view->with('tags', $tags);
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
