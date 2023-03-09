<?php

namespace Tests\Feature\Admin\Employees;

use App\Models\Employee;
use Illuminate\Auth\Events\Lockout;
use App\Repositories\Employees\EmployeeRepository;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class EmployeeFeatureTest extends TestCase
{
    /** @test */
    public function it_should_go_directly_to_dashboard_when_employee_is_already_logged_in()
    {
        // dd(\DB::connection()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME));
        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.login'))
            ->assertStatus(302)
            ->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function it_can_show_the_admin_login_form()
    {
        $this->get(route('admin.login'))
            ->assertStatus(200)
            ->assertSee('Sign in to start your session');
    }

    /** @test */
    public function it_redirects_back_to_login_page_when_credentials_are_wrong()
    {
        $employee = Employee::factory()->create();

        $data = [
            'email' => $employee->email,
            'password' => 'unknown'
        ];

        $this->post(route('admin.login'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors();
    }

    /** @test */
    public function it_can_login_to_the_dashboard()
    {
        $employee = Employee::factory()->create();

        $data = [
            'email' => $employee->email,
            'password' => 'secret'
        ];

        $this->post(route('admin.login'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function it_can_update_the_profile()
    {
        
        $data = ['name' => 'King Kong', 'email' => 'test@test.com'];
        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.employee.profile.update', $this->employee->id), $data)
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Update successful']);
    }

    /** @test */
    public function it_can_show_the_profile_of_the_logged_user()
    {
        $employee = Employee::factory()->create();

        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.employee.profile', $employee->id))
            ->assertStatus(200)
            ->assertSee(htmlentities($employee->name, ENT_QUOTES));
    }

    /** @test */
    public function it_errors_when_editing_an_employee_that_is_not_found()
    {
        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.employees.edit', 999))
            ->assertStatus(404);
    }

    /** @test */
    public function it_errors_when_looking_for_an_employee_that_is_not_found()
    {
        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.employees.show', 999))
            ->assertStatus(404);
    }

    /** @test */
    public function it_can_list_all_the_employees()
    {
        $employee = Employee::factory()->create();

        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.employees.index'))
            ->assertStatus(200)
            ->assertSee(htmlentities($employee->name, ENT_QUOTES));
    }

    /** @test */
    public function it_errors_when_the_email_is_already_taken()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->employee->email,
            'password' => 'secret'
        ];

        $this->actingAs($this->employee, 'employee')
            ->post(route('admin.employees.store'), $data)
            ->assertStatus(302)
            ->assertSessionHas(['errors']);
    }

    /** @test */
    public function it_errors_if_the_password_is_less_than_eight_characters()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];

        $this->actingAs($this->employee, 'employee')
            ->post(route('admin.employees.store'), $data)
            ->assertStatus(302)
            ->assertSessionHas(['errors']);
    }

    /** @test */
    public function it_can_only_soft_delete_an_employee()
    {
        $employee = Employee::factory()->create();

        $this->actingAs($this->employee, 'employee')
            ->delete(route('admin.employees.destroy', $employee->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.employees.index'));

        $this->assertDatabaseHas('employees', ['name' => $employee->name]);
    }

    /** @test */
    public function it_should_update_the_employee_password()
    {
        $employee = Employee::factory()->create();

        $update = [
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => 'secret!!'
        ];

        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.employees.update', $employee->id), $update)
            ->assertStatus(302)
            ->assertRedirect(route('admin.employees.edit', $employee->id));

        $collection = collect($update)->except('password');
        $this->assertDatabaseHas('employees', $collection->all());
    }

    /** @test */
    public function it_can_update_the_employee()
    {
        $update = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'status' => 0
        ];

        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.employees.update', $this->employee->id), $update)
            ->assertStatus(302)
            ->assertRedirect(route('admin.employees.edit', $this->employee->id));

        $this->assertDatabaseHas('employees', $update);
    }

    /** @test */
    public function it_can_show_the_employee()
    {
        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.employees.show', $this->employee->id))
            ->assertStatus(200)
            ->assertViewHas('employee');
    }

    /** @test */
    public function it_can_create_an_employee()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret!!',
            'role' => $this->role->id
        ];

        $this->actingAs($this->employee, 'employee')
            ->post(route('admin.employees.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.employees.index'));

        $created = collect($data)->except('password', 'role');

        $this->assertDatabaseHas('employees', $created->all());
    }
}
