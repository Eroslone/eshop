<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipients',
        'phone',
        'province_name',
        'city_name','district_name','address','default'
    ];

    //关联用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //关联订单
    public function order()
    {
        return $this->hasMany(Order::class,'address_id');
    }

}
