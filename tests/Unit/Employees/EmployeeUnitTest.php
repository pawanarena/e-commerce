<?php

namespace Tests\Unit\Employees;

use App\Models\Employee;
use App\Repositories\Employees\EmployeeRepository;
use App\Repositories\Roles\RoleRepository;
use App\Models\Role;
use Tests\TestCase;

class EmployeeUnitTest extends TestCase
{
    /** @test */
    public function it_can_list_all_the_roles_associated_to_the_employee()
    {
        $employee = Employee::factory()->create();

        $roleRepo = new RoleRepository(new Role);
        $userRole = $roleRepo->createRole(['name' => 'user']);

        $employeeRepo = new EmployeeRepository($employee);
        $employeeRepo->syncRoles([$userRole->id]);

        $employeeRoles = $employeeRepo->listRoles();

        $this->assertCount(1, $employeeRoles->all());

        $employeeRoles->each(function (Role $role) use ($userRole) {
            $this->assertEquals($userRole->name, $role->name);
        });
    }
}
