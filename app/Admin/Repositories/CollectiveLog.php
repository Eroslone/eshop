<?php

namespace App\Admin\Repositories;

use App\Models\CollectiveLog as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class CollectiveLog extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
