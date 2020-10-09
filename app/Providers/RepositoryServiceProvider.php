<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\UserRepositoryInterface;
use App\Repository\UserRepository;
use App\Repository\TweetRepositoryInterface;
use App\Repository\TweetRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TweetRepositoryInterface::class, TweetRepository::class);
    }
}
