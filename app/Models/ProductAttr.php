<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttr extends Model
{
    use HasFactory;

    protected $appends = [
        'differences',
    ];

    public function getDifferencesAttribute()
    {

        return implode(',',json_decode($this->attributes['difference'],true));
    }

    //关联购物车
//    public function shop_car()
//    {
//        return $this->hasMany(Shop_car::class);
//    }

    //关联订单
    public function shop()
    {
        return $this->hasMany(OrderSons::class);
    }


    public function exchange_goods()
    {
        return $this->hasMany(Exchange_goods::class);
    }
}
