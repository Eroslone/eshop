<?php

namespace App\Admin\Repositories;

use App\Models\Attributes as AttributesModel;
use Dcat\Admin\Repositories\EloquentRepository;

class Attributes extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = AttributesModel::class;
}
