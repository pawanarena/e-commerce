<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Roles\RoleRepository;
use App\Models\Employee;
use App\Models\Role;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $faker;
    protected $employee;
    protected $role;

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
    }
    public function tearDown(): void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
