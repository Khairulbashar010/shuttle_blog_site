<?php

namespace App\Providers;

use App\Interfaces\PostRepositoryInterface;
use App\Repositories\PostRepository;
use App\Interfaces\CommentRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Interfaces\TagRepositoryInterface;
use App\Repositories\TagRepository;
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
