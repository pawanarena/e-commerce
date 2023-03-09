<?php

namespace App\Repositories\Roles\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function createRole(array $data) : Role;

    public function listRoles(string $order = 'id', string $sort = 'desc') : Collection;

    public function findRoleById(int $id);

    public function updateRole(array $data) : bool;

    public function deleteRoleById() : bool;

    public function attachToPermission(Permission $permission);

    public function attachToPermissions(... $permissions);

    public function syncPermissions(array $ids);

    public function listPermissions() : Collection;
}
