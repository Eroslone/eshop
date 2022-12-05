<?php

namespace App\Admin\Repositories;

use App\Models\Address as AddressModel;
use Dcat\Admin\Repositories\EloquentRepository;

class Address extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = AddressModel::class;
}
