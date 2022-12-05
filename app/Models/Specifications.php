<?php

namespace App\Models;

use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specifications extends Model
{
    use HasFactory;
    use dateTrait;

    public function attributes()
    {
        return $this->belongsTo(Attributes::class);
    }
}
