<?php

namespace App\Models;


use App\Traits\dateTrait;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    use ModelTree;
    use dateTrait;

    protected $titleColumn = 'name';
    protected $parentColumn = 'pid';

    //关联产品
    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
