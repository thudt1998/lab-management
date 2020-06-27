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
        $this->app->bind(\App\Repositories\CompartmentRepository::class, \App\Repositories\CompartmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProjectTypeRepository::class, \App\Repositories\ProjectTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProjectRepository::class, \App\Repositories\ProjectRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProjectStudentRepository::class, \App\Repositories\ProjectStudentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TopicRepository::class, \App\Repositories\TopicRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TopicProjectRepository::class, \App\Repositories\TopicProjectRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DeviceRepository::class, \App\Repositories\DeviceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MessageRepository::class, \App\Repositories\MessageRepositoryEloquent::class);
        //:end-bindings:
    }
}
