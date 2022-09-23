<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepoInterface;
use App\Interfaces\MyFileRepoInterface;
use App\Repo\MyFileRepo;
use App\Repo\UserRepo;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepoInterface::class, UserRepo::class);
        $this->app->bind(MyFileRepoInterface::class, MyFileRepo::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
