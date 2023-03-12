<?php

namespace App\Repositories\Countries;

use Jsdecena\Baserepo\BaseRepository;
use App\Repositories\Countries\Interfaces\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Models\Country;
use Illuminate\Support\Collection;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    /**
     * CountryRepository constructor.
     * @param Country $country
     */
    public function __construct(Country $country)
    {
        parent::__construct($country);
        $this->model = $country;
    }

    /**
     * List all the countries
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listCountries(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->model->where('status', 1)->get();
    }

    /**
     * @param array $params
     * @return Country
     */
    public function createCountry(array $params) : Country
    {
        return $this->create($params);
    }

    /**
     * Find the country
     *
     * @param $id
     * @return Country
     */
    public function findCountryById(int $id) : Country
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Country not found.');
        }
    }

    /**
     * Show all the provinces
     *
     * @return mixed
     */
    public function findProvinces()
    {
        return $this->model->provinces;
    }

    /**
     * Update the country
     *
     * @param array $params
     *
     * @return Country
     */
    public function updateCountry(array $params) : Country
    {
        try {
            $this->model->update($params);
            return $this->findCountryById($this->model->id);
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @return Collection
     */
    public function listStates() : Collection
    {
        return $this->model->states()->get();
    }
}
