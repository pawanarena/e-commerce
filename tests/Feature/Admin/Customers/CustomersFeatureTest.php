<?php

namespace Tests\Feature\Admin\Customers;

use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Repositories\Customers\CustomerRepository;
use App\Models\Province;
use Illuminate\Support\Str;
use Tests\TestCase;

class CustomersFeatureTest extends TestCase
{
    /** @test */
    public function it_can_edit_the_customer_address()
    {
        Country::factory()->create();
        Province::factory()->create();
        City::factory()->create();
        $customer = Customer::factory()->create();
        $address = Address::factory()->create();

        $customerRepo = new CustomerRepository($customer);
        $attachedAddress = $customerRepo->attachAddress($address);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.customers.addresses.edit', [$customer->id, $attachedAddress->id]))
            ->assertStatus(200)
            ->assertSee($address->alias);
    }

    /** @test */
    public function it_can_show_the_customer_address()
    {
        City::factory()->create();
        $customer = Customer::factory()->create();
        $address = Address::factory()->create();

        $customerRepo = new CustomerRepository($customer);
        $customerRepo->attachAddress($address);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.customers.addresses.show', [$customer->id, $address->id]))
            ->assertStatus(200)
            ->assertSee($address->alias);
    }
    
    /** @test */
    public function it_can_delete_the_customer()
    {
        $customer = Customer::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->delete(route('admin.customers.destroy', $customer->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('message', 'Delete successful');
    }
    
    /** @test */
    public function it_can_show_the_create_and_edit_page()
    {
        $customer = Customer::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.customers.create'))
            ->assertStatus(200);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.customers.edit', $customer->id))
            ->assertStatus(200)
            ->assertSee(htmlentities($customer->name, ENT_QUOTES));
    }

    /** @test */
    public function it_can_search_for_the_customer()
    {
        $customer = Customer::factory()->create();

        $param = ['q' => Str::slug($customer->name, 5)];

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.customers.index', $param))
            ->assertStatus(200);
    }
    
    /** @test */
    public function it_can_update_the_customers_password()
    {
        $customer = Customer::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'unknown'
        ];

        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.customers.update', $customer->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.customers.edit', $customer->id));
    }

    /** @test */
    public function it_can_show_all_the_customers()
    {
        Customer::factory(20)->create();

        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.customers.index'))
            ->assertViewHas(['customers']);
    }
    
    /** @test */
    public function it_can_show_the_customer()
    {
        $customer = Customer::factory()->create();

        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.customers.show', $customer->id))
            ->assertViewHas(['customer'])
            ->assertSeeText(htmlentities($customer->name, ENT_QUOTES));
    }
    
    /** @test */
    public function it_can_update_the_customer()
    {
        $customer = Customer::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ];

        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.customers.update', $customer->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.customers.edit', $customer->id));

        $this->assertDatabaseHas('customers', $data);
    }

    /** @test */
    public function it_can_create_the_customer()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret!!'
        ];

        $this->actingAs($this->employee, 'employee')
            ->post(route('admin.customers.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.customers.index'));

        $created = collect($data)->except('password');

        $this->assertDatabaseHas('customers', $created->all());
    }
}
