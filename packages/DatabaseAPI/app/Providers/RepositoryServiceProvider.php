<?php

namespace App\Providers;

use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\Contracts\AddressRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentRepositoryInterface;
use App\Repositories\Eloquent\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, EloquentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
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
