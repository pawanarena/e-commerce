<?php

namespace Tests\Feature\Admin\Permissions;

use App\Models\Permission;
use Tests\TestCase;

class PermissionFeatureTest extends TestCase
{
    /** @test */
    public function it_can_display_all_the_permissions()
    {
        $permission = Permission::factory()->create();
        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.permissions.index'))
            ->assertSee($permission->display_name)
            ->assertStatus(200);
    }
}
