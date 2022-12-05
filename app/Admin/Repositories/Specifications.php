<?php

namespace App\Admin\Repositories;

use App\Models\Specifications as SpecificationsModel;
use Dcat\Admin\Repositories\EloquentRepository;

class Specifications extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = SpecificationsModel::class;
}
