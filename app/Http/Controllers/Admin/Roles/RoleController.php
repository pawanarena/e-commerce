<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Repositories\Permissions\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Roles\RoleRepository;
use App\Repositories\Roles\Interfaces\RoleRepositoryInterface;
use App\Http\Requests\Roles\CreateRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;

class RoleController extends Controller
{
    private $roleRepo;
    private $permissionRepository;

    /**
     * RoleController constructor.
     *
     * @param RoleRepositoryInterface $roleRepository
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository
    ) {
        $this->roleRepo = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $list = $this->roleRepo->listRoles('name', 'asc')->all();

        $roles = $this->roleRepo->paginateArrayResults($list);

        return view('admin.roles.list', compact('roles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * @param CreateRoleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRoleRequest $request)
    {
        $this->roleRepo->createRole($request->except('_method', '_token'));

        return redirect()->route('admin.roles.index')
            ->with('message', 'Create role successful!');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $role = $this->roleRepo->findRoleById($id);

        $roleRepo = new RoleRepository($role);
        $attachedPermissionsArrayIds = $roleRepo->listPermissions()->pluck('id')->all();
        $permissions = $this->permissionRepository->listPermissions(['*'], 'name', 'asc');

        return view('admin.roles.edit', compact(
            'role',
            'permissions',
            'attachedPermissionsArrayIds'
        ));
    }

    /**
     * @param UpdateRoleRequest $request
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = $this->roleRepo->findRoleById($id);

        if ($request->has('permissions')) {
            $roleRepo = new RoleRepository($role);
            $roleRepo->syncPermissions($request->input('permissions'));
        }

        $this->roleRepo->updateRole($request->except('_method', '_token'), $id);

        return redirect()->route('admin.roles.edit', $id)
            ->with('message', 'Update role successful!');
    }
}
