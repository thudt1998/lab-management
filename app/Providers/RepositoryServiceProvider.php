<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\ManagerRepository::class, \App\Repositories\ManagerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\LecturerRepository::class, \App\Repositories\LecturerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StudentRepository::class, \App\Repositories\StudentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SubjectRepository::class, \App\Repositories\SubjectRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\LaboratoryRepository::class, \App\Repositories\LaboratoryRepositoryEloquent::class);
        //:end-bindings:
    }
}
