<?php

namespace App\Admin\Repositories;

use App\Models\SeckillProduct as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class SeckillProduct extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
