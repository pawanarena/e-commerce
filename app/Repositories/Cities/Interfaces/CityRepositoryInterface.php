<?php

namespace App\Repositories\Cities\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Models\City;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function listCities();

    public function findCityById(int $id) : City;

    public function updateCity(array $params) : bool;

    public function findCityByName(string $name) : City;
}
