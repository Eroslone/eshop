<?php

namespace App\Admin\Repositories;

use App\Models\Products as ProductsModel;
use Dcat\Admin\Repositories\EloquentRepository;

class Products extends EloquentRepository
{
    protected $eloquentClass = ProductsModel::class;
}
