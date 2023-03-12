<?php

namespace App\Repositories\Cities;

use Jsdecena\Baserepo\BaseRepository;
use App\Repositories\Cities\Interfaces\CityRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\City;
use Illuminate\Support\Collection;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    /**
     * CityRepository constructor.
     *
     * @param City $city
     */
    public function __construct(City $city)
    {
        parent::__construct($city);
        $this->model = $city;
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return mixed
     */
    public function listCities($columns = ['*'], string $orderBy = 'name', string $sortBy = 'asc')
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @param int $id
     * @return City
     *
     * @deprecated @findCityByName
     */
    public function findCityById(int $id) : City
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception('City not found.');
        }
    }

    /**
     * @param array $params
     *
     * @return boolean
     */
    public function updateCity(array $params) : bool
    {
        $this->model->update($params);
        return $this->model->save();
    }

    /**
     * @param string $state_code
     *
     * @return Collection
     */
    public function listCitiesByStateCode(string $state_code) : Collection
    {
        return $this->model->where(compact('state_code'))->get();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function findCityByName(string $name) : City
    {
        try {
            return $this->model->where(compact('name'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new \Exception('City not found.');
        }
    }
}
