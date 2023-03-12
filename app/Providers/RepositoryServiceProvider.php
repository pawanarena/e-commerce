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
use App\Repositories\Attributes\AttributeRepository;
use App\Repositories\Attributes\Interfaces\AttributeRepositoryInterface;
use App\Repositories\AttributeValues\AttributeValueRepository;
use App\Repositories\AttributeValues\Interfaces\AttributeValueRepositoryInterface;
use App\Repositories\ProductAttributes\ProductAttributeRepository;
use App\Repositories\ProductAttributes\Interfaces\ProductAttributeRepositoryInterface;
use App\Repositories\Brands\BrandRepository;
use App\Repositories\Brands\Interfaces\BrandRepositoryInterface;
use App\Repositories\Products\Interfaces\ProductRepositoryInterface;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Countries\CountryRepository;
use App\Repositories\Countries\Interfaces\CountryRepositoryInterface;
use App\Repositories\Provinces\ProvinceRepository;
use App\Repositories\Provinces\Interfaces\ProvinceRepositoryInterface;
use App\Repositories\Cities\CityRepository;
use App\Repositories\Cities\Interfaces\CityRepositoryInterface;
use App\Repositories\Addresses\AddressRepository;
use App\Repositories\Addresses\Interfaces\AddressRepositoryInterface;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Customers\Interfaces\CustomerRepositoryInterface;
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

        $this->app->bind(
            AttributeRepositoryInterface::class,
            AttributeRepository::class
        );

        $this->app->bind(
            AttributeValueRepositoryInterface::class,
            AttributeValueRepository::class
        );

        $this->app->bind(
            ProductAttributeRepositoryInterface::class,
            ProductAttributeRepository::class
        );

        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            CountryRepositoryInterface::class,
            CountryRepository::class
        );
        
        $this->app->bind(
            ProvinceRepositoryInterface::class,
            ProvinceRepository::class
        );

        $this->app->bind(
            CityRepositoryInterface::class,
            CityRepository::class
        );

        $this->app->bind(
            AddressRepositoryInterface::class,
            AddressRepository::class
        );

        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );
    }
}
