<?php

namespace Tests\Unit\Address;

use App\Models\Address;
use App\Repositories\Addresses\AddressRepository;
use App\Traits\AddressTransformable;
use App\Repositories\Cities\CityRepository;
use App\Models\Customer;
use App\Repositories\Customers\CustomerRepository;
use App\Models\Order;
use App\Models\Province;
use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Str;
use Tests\TestCase;

class AddressUnitTest extends TestCase
{
    use AddressTransformable;

    /** @test */
    // public function it_shows_the_orders_for_this_address()
    // {
    //     $address = Address::factory()->create();
    //     Order::factory()->create([
    //         'address_id' => $address->id
    //     ]);

    //     $repo = new AddressRepository($address);
    //     $orders = $repo->findOrders();

    //     $orders->each(function ($item) use ($address) {
    //         $this->assertEquals($address->id, $item->address_id);
    //     });
    // }

    /** @test */
    public function it_returns_the_country_of_the_address()
    {
        $country = Country::factory()->create();
        $province = Province::factory()->create();
        $city = City::factory()->create();
        $address = Address::factory()->create([
            'country_id' => $country->id,
            'province_id' => $province->id,
            'city' => $city->name
        ]);

        $repo = new AddressRepository($address);
        $foundCountry = $repo->findCountry();
        $foundProvince = $repo->findProvince();

        $cityRepo = new CityRepository($city);
        $foundCity = $cityRepo->findCityByName($address->city);

        $this->assertInstanceOf(Country::class, $foundCountry);
        $this->assertInstanceOf(Province::class, $foundProvince);
        $this->assertInstanceOf(City::class, $foundCity);
        $this->assertEquals($country->name, $foundCountry->name);
        $this->assertEquals($province->name, $foundProvince->name);
        $this->assertEquals($city->name, $foundCity->name);
    }

    /** @test */
    public function it_can_transform_address()
    {
        $city = City::factory()->create();
        $province = Province::factory()->create();
        $country = Country::factory()->create();
        $customer = Customer::factory()->create();
        $address = Address::factory()->create([
            'city' => $city->name,
            'province_id' => $province->id,
            'country_id' => $country->id,
            'customer_id' => $customer->id,
        ]);

        $transformed = $this->transformAddress($address);

        $this->assertEquals($city->name, $transformed->city);
        $this->assertEquals($province->name, $transformed->province);
        $this->assertEquals($country->name, $transformed->country);
        $this->assertEquals($customer->name, $transformed->customer);
    }

    /** @test */
    public function it_can_search_the_address()
    {
        $address1 = $this->faker->address;
        $address = Address::factory()->create([
            'address_1' => $address1
        ]);

        $repo = new AddressRepository(new Address());
        $results = $repo->searchAddress(Str::limit($address->address_1, 5, ''));

        $this->assertTrue((bool) $results->count());
    }

    /** @test */
    public function it_can_return_the_owner_of_the_address()
    {
        $customer = Customer::factory()->create();
        $address = Address::factory()->create(['customer_id' => $customer->id]);

        $addressRepo = new AddressRepository($address);

        $found = $addressRepo->findCustomer();

        $this->assertEquals($customer->name, $found->name);
    }

    /** @test */
    public function it_can_be_attached_to_a_customer()
    {
        $customer = Customer::factory()->create();
        $address = Address::factory()->create();

        $addressRepo = new AddressRepository($address);
        $addressRepo->attachToCustomer($address, $customer);

        $this->assertEquals($customer->name, $address->customer->name);
    }

    /** @test */
    public function it_errors_when_the_address_is_not_found()
    {
        $this->expectException(\Exception::class);

        $address = new AddressRepository(new Address);
        $address->findAddressById(999);
    }

    /** @test */
    public function it_can_list_all_the_addresses()
    {
        $address = Address::factory()->create();

        $address = new AddressRepository($address);
        $addresses = $address->listAddress();

        foreach ($addresses as $list) {
            $this->assertDatabaseHas('addresses', ['alias' => $list->alias]);
        }
    }

    /** @test */
    public function it_errors_when_creating_an_address()
    {
        $this->expectException(\Exception::class);

        $address = new AddressRepository(new Address);
        $address->createAddress([]);
    }

    /** @test */
    public function it_can_show_the_address()
    {
        $address = Address::factory()->create();

        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }

    /** @test */
    public function it_can_list_all_the_addresses_of_the_customer()
    {
        $customer = Customer::factory()->create();
        Address::factory()->create(['customer_id' => $customer->id]);

        $customerRepo = new CustomerRepository($customer);
        $lists = $customerRepo->findAddresses();

        $this->assertCount(1, $lists);
    }

    /** @test */
    public function it_can_soft_delete_the_address()
    {
        $created = Address::factory()->create();

        $address = new AddressRepository($created);
        $address->deleteAddress();

        $this->assertDatabaseHas('addresses', ['id' => $created->id]);
    }

    /** @test */
    public function it_can_update_the_address()
    {
        $address = Address::factory()->create();

        $data = [
            'alias' => $this->faker->unique()->word,
            'address_1' => $this->faker->unique()->word,
            'address_2' => null,
            'zip' => 1101,
            'status' => 1
        ];

        $addressRepo = new AddressRepository($address);
        $updated = $addressRepo->updateAddress($data);

        $address = $addressRepo->findAddressById($address->id);

        $this->assertTrue($updated);
        $this->assertEquals($data['alias'], $address->alias);
        $this->assertEquals($data['address_1'], $address->address_1);
        $this->assertEquals($data['address_2'], $address->address_2);
        $this->assertEquals($data['zip'], $address->zip);
        $this->assertEquals($data['status'], $address->status);
    }

    /** @test */
    public function it_can_create_the_address()
    {
        $country = Country::factory()->create();
        $province = Province::factory()->create();
        $city = City::factory()->create();
        $customer = Customer::factory()->create();

        $data = [
            'alias' => 'home',
            'address_1' => $this->faker->streetName,
            'address_2' => $this->faker->streetAddress,
            'zip' => $this->faker->postcode,
            'city' => $city->name,
            'province_id' => $province->id,
            'country_id' => $country->id,
            'customer_id' => $customer->id,
            'status' => 1
        ];

        $addressRepo = new AddressRepository(new Address);
        $address = $addressRepo->createAddress($data);

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($data['alias'], $address->alias);
        $this->assertEquals($data['address_1'], $address->address_1);
        $this->assertEquals($data['address_2'], $address->address_2);
        $this->assertEquals($data['zip'], $address->zip);
        $this->assertEquals($data['status'], $address->status);
    }
}
