<?php

namespace App\Models;

use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Collective extends Model
{
    use SoftDeletes;
    use dateTrait;

    protected $fillable = [
        'store_id', 'goods_id', 'discount', 'need'
    ];
    // 定义拼团的 3 种状态
    const STATUS_FUNDING = '2';
    const STATUS_SUCCESS = '1';
    const STATUS_FAIL = '0';

    public static $statusMap = [
        self::STATUS_FUNDING => '拼团中',
        self::STATUS_SUCCESS => '拼团成功',
        self::STATUS_FAIL    => '拼团失败',
    ];
    public function products()
    {
        return $this->hasOne('App\Models\Products', 'id', 'goods_id')->withTrashed();
    }
    public function collectivelogs()
    {
        return $this->hasMany('App\Models\CollectiveLog', 'id', 'collective_id')->withTrashed();
    }
}
