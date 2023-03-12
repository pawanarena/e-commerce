<?php
namespace Database\Seeders;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerAddressesTableSeeder extends Seeder
{
    public function run()
    {
        Customer::factory(3)->create()->each(function ($customer) {
            Address::factory(3)->make()->each(function($address) use ($customer) {
                $customer->addresses()->save($address);
            });
        });
    }
}