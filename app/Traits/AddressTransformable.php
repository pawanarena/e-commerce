<?php

namespace App\Traits;

use App\Models\Address;
use App\Repositories\Cities\CityRepository;
use App\Repositories\Countries\CountryRepository;
use App\Models\Customer;
use App\Repositories\Customers\CustomerRepository;
use App\Models\Province;
use App\Repositories\Provinces\ProvinceRepository;
use App\Models\City;
use App\Models\Country;

trait AddressTransformable
{
    /**
     * Transform the address
     *
     * @param Address $address
     *
     * @return Address
     * @throws \App\Shop\Cities\Exceptions\CityNotFoundException
     * @throws \App\Shop\Countries\Exceptions\CountryNotFoundException
     * @throws \App\Shop\Customers\Exceptions\CustomerNotFoundException
     */
    public function transformAddress(Address $address)
    {
        $obj = new Address;
        $obj->id = $address->id;
        $obj->alias = $address->alias;
        $obj->address_1 = $address->address_1;
        $obj->address_2 = $address->address_2;
        $obj->zip = $address->zip;
        $obj->city = $address->city;

        if (isset($address->province_id)) {
            $provinceRepo = new ProvinceRepository(new Province);
            $province = $provinceRepo->findProvinceById($address->province_id);
            $obj->province = $province->name;
        }

        $countryRepo = new CountryRepository(new Country);
        $country = $countryRepo->findCountryById($address->country_id);
        $obj->country = $country->name;

        $customerRepo = new CustomerRepository(new Customer);
        $customer = $customerRepo->findCustomerById($address->customer_id);
        $obj->customer = $customer->name;
        $obj->status = $address->status;

        return $obj;
    }
}
