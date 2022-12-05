<?php

namespace App\Admin\Repositories;

use App\Models\Categories as CategoriesModel;
use Dcat\Admin\Repositories\EloquentRepository;

class Categories extends EloquentRepository
{
    protected $eloquentClass = CategoriesModel::class;
}
