<?php

namespace App\Models;


use App\Http\Controllers\Api\ProductsController;
use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    use HasFactory;
    use dateTrait;

    protected $appends = [
        'pictures',
        'picture_url'
    ];
    public function getAttrAttribute($value)
    {
        return array_values(json_decode($value, true) ?: []);
    }

    public function setAttrAttribute($value)
    {
        $pro=new ProductsController();
        $pro->productAttr(array_values($value),$this->attributes['number']);
        $this->attributes['attr'] = json_encode(array_values($value));
    }

// 获取缩略图地址
    public function getPictureUrlAttribute()
    {
        // 拼接完整的 URL
        return env('APP_URL') . "/storage/" . json_decode($this->attributes['pictures'])[0];
    }

    public function setPicturesAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['pictures'] = json_encode(array_values($pictures));
        }
    }

    public function getPicturesAttribute()
    {
        $pictureList = json_decode( $this->attributes['pictures']);
        foreach ($pictureList as $key => $value) {
            $pictureList[$key] = env('APP_URL') . "/storage/" . $value;
        }
        return $pictureList;
    }

    public function orderSons()
    {
        return $this->hasMany(OrderSons::class);
    }

    //关联类型
    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function seckill()
    {
        return $this->hasOne(SeckillProduct::class);
    }

    public function exchange_goods()
    {
        return $this->hasMany(Exchange_goods::class);
    }
    // 关联拼团
    public function collective()
    {
        return $this->hasMany('App\Models\Collective', 'goods_id', 'id')->withTrashed();
    }
}
