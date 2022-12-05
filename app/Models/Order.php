<?php

namespace App\Models;

use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use dateTrait;

    protected $fillable = [
        'user_id', 'no', 'address_id', 'price', 'remark', 'state','type', 'paid_at', 'payment_method', 'over_time', 'express_company', 'express_no',
        'pay_status', 'refund', 'refund_reason', 'refund_no', 'refuse_reason'
    ];
    protected $appends = [
        'state_info',
    ];

    public function getStateInfoAttribute()
    {
        $state = ['0' => '未付款', '1' => '已付款，待发货', '2' => '已发货', '3' => '已完成', '-1' => '已取消',];
        return $state[$this->attributes['state']];
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //关联子表
    public function orderSon()
    {
        return $this->hasMany(OrderSons::class, 'order_id');
    }

    //关联地址
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function exchange_goods()
    {
        return $this->belongsTo(Exchange_goods::class,'order_son_id');
    }

}
