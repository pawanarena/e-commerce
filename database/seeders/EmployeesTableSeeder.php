<?php
namespace Database\Seeders;
use App\Models\Employee;
use App\Models\Permission;
use App\Repositories\Roles\RoleRepository;
use App\Models\Role;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    public function run()
    {
        $createProductPerm = Permission::factory()->create([
            'name' => 'create-product',
            'display_name' => 'Create product'
        ]);

        $viewProductPerm = Permission::factory()->create([
            'name' => 'view-product',
            'display_name' => 'View product'
        ]);

        $updateProductPerm = Permission::factory()->create([
            'name' => 'update-product',
            'display_name' => 'Update product'
        ]);

        $deleteProductPerm = Permission::factory()->create([
            'name' => 'delete-product',
            'display_name' => 'Delete product'
        ]);

        $updateOrderPerm = Permission::factory()->create([
            'name' => 'update-order',
            'display_name' => 'Update order'
        ]);

        $employee = Employee::factory()->create([
            'email' => 'john@doe.com'
        ]);

        $super = Role::factory()->create([
            'name' => 'superadmin',
            'display_name' => 'Super Admin'
        ]);

        $roleSuperRepo = new RoleRepository($super);
        $roleSuperRepo->attachToPermission($createProductPerm);
        $roleSuperRepo->attachToPermission($viewProductPerm);
        $roleSuperRepo->attachToPermission($updateProductPerm);
        $roleSuperRepo->attachToPermission($deleteProductPerm);
        $roleSuperRepo->attachToPermission($updateOrderPerm);

        $employee->roles()->save($super);

        $employee = Employee::factory()->create([
            'email' => 'admin@doe.com'
        ]);

        $admin = Role::factory()->create([
            'name' => 'admin',
            'display_name' => 'Admin'
        ]);

        $roleAdminRepo = new RoleRepository($admin);
        $roleAdminRepo->attachToPermission($createProductPerm);
        $roleAdminRepo->attachToPermission($viewProductPerm);
        $roleAdminRepo->attachToPermission($updateProductPerm);
        $roleAdminRepo->attachToPermission($deleteProductPerm);
        $roleAdminRepo->attachToPermission($updateOrderPerm);

        $employee->roles()->save($admin);

        $employee = Employee::factory()->create([
            'email' => 'clerk@doe.com'
        ]);

        $clerk = Role::factory()->create([
            'name' => 'clerk',
            'display_name' => 'Clerk'
        ]);

        $roleClerkRepo = new RoleRepository($clerk);
        $roleClerkRepo->attachToPermission($createProductPerm);
        $roleClerkRepo->attachToPermission($viewProductPerm);
        $roleClerkRepo->attachToPermission($updateProductPerm);

        $employee->roles()->save($clerk);
    }
}
