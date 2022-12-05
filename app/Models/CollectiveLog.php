<?php

namespace App\Models;

use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CollectiveLog extends Model
{
    use SoftDeletes;
    use dateTrait;

    protected $table = 'collective_logs';
    protected $fillable = [
        'collective_id','user_id','store_id', 'goods_id', 'discount', 'need','status'
    ];
    public function collective()
    {
        return $this->hasOne('App\Models\Collective', 'id', 'collective_id')->withTrashed();
    }
}
