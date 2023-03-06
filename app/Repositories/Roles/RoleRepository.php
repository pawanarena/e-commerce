<?php
namespace App\Repositories\Roles;

use Jsdecena\Baserepo\BaseRepository;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    protected $model;
    public function __construct(Role $role)
    {
        parent::__construct($role);
        $this->model = $role;
    }
    /**
     * List all Roles
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listRoles(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->all(['*'], $order, $sort);
    }
    /**
     * @param array $data
     * @return Role
     */
    public function createRole(array $data) : Role
    {
        try {
            $role = new Role($data);
            $role->save();
            return $role;
        } catch (QueryException $e) {
            return 'Failed to create user: ' . $e->getMessage();
        }
    }

    /**
     * @param int $id
     *
     * @return Role
     */
    public function findRoleById(int $id) : Role
    {
        try {
            return $this->findOneOrFail($id);
        } catch (QueryException $e) {
            return 'Failed to find user: ' . $e->getMessage();
        }
    }

    /**
     * @param array $data
     *
     * @return bool
     * @throws UpdateRoleErrorException
     */
    public function updateRole(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            return 'Failed to update user: ' . $e->getMessage();
        }
    }

    /**
     * @return bool
     * @throws DeleteRoleErrorException
     */
    public function deleteRoleById() : bool
    {
        try {
            return $this->delete();
        } catch (QueryException $e) {
            return 'Failed to delete user: ' . $e->getMessage();
        }
    }

    /**
     * @param Permission $permission
     */
    public function attachToPermission(Permission $permission)
    {
        $this->model->attachPermission($permission);
    }

    /**
     * @param Permission ...$permissions
     */
    public function attachToPermissions(... $permissions)
    {
        $this->model->attachPermissions($permissions);
    }

    /**
     * @param array $ids
     */
    public function syncPermissions(array $ids)
    {
        $this->model->syncPermissions($ids);
    }

    /**
     * @return Collection
     */
    public function listPermissions() : Collection
    {
        return $this->model->permissions()->get();
    }
}
