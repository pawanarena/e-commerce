<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Roles\RoleRepository;
use App\Models\Employee;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $faker;
    protected $employee;
    protected $role;
    protected $category;
    protected $product;

    /**
     * Set up the test
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();
        $this->employee = Employee::factory()->create();

        $adminData = ['name' => 'admin'];

        $roleRepo = new RoleRepository(new Role);
        $admin = $roleRepo->createRole($adminData);
        $this->role = $admin;

        $this->category = Category::factory()->create();
        $this->product = Product::factory()->create();
    }
    public function tearDown(): void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
