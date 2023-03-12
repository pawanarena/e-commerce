<?php

namespace App\Repositories\Addresses\Interfaces;

use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Support\Collection;
use Jsdecena\Baserepo\BaseRepositoryInterface;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function createAddress(array $params) : Address;

    public function attachToCustomer(Address $address, Customer $customer);

    public function updateAddress(array $update): bool;

    public function deleteAddress();

    public function listAddress(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function findAddressById(int $id) : Address;

    public function findCustomer() : Customer;

    public function searchAddress(string $text) : Collection;

    public function findCountry() : Country;

    public function findProvince() : Province;

    public function findCity() : City;
}
