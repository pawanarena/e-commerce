<?php

namespace App\Repositories\Employees\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Models\Employee;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    public function listEmployees(string $order = 'id', string $sort = 'desc'): Collection;

    public function createEmployee(array $params) : Employee;

    public function findEmployeeById(int $id) : Employee;

    public function updateEmployee(array $params): bool;

    public function syncRoles(array $roleIds);

    public function listRoles() : Collection;

    public function hasRole(string $roleName) : bool;

    public function isAuthUser(Employee $employee): bool;

    public function deleteEmployee() : bool;
}
