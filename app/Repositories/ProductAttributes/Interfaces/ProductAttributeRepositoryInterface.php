<?php

namespace App\Repositories\ProductAttributes\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;

interface ProductAttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function findProductAttributeById(int $id);
}
