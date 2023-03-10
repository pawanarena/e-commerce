<?php

namespace App\Providers;


use App\Repositories\Employees\EmployeeRepository;
use App\Repositories\Employees\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Permissions\PermissionRepository;
use App\Repositories\Permissions\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Roles\RoleRepository;
use App\Repositories\Roles\Interfaces\RoleRepositoryInterface;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );

        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
    }
}
