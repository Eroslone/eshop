<?php

namespace App\Models;

use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    use dateTrait;

    public function specifications()
    {
        return $this->hasMany(Specifications::class);
    }
}
