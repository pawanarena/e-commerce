<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Employee;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $faker;
    protected $employee;

    /**
     * Set up the test
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();
        $this->employee = Employee::factory()->create();
    }
}
