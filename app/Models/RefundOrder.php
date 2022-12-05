<?php

namespace App\Models;

use App\Traits\dateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundOrder extends Model
{
    use HasFactory;
    use dateTrait;

    protected $fillable = [
        'user_id', 'order_id', 'no', 'order_son_id', 'address_id', 'refund_reason', 'refund_image', 'refund_describe', 'express_company', 'refund_no', 'refuse_reason', 'express_company', 'freight_state',
        'return_way', 'state'
    ];


    protected $appends = [
//        'state_info',
        'refund_info',
        'image_info'
    ];

    public function getImageInfoAttribute()
    {
        return explode(',', $this->attributes['refund_image']);
    }

    public function getRefundInfoAttribute()
    {
        $state = ['0' => '未退款', '1' => '申请退款中', '2' => '商家已同意退款', '3' => '商家已拒绝退款', '4' => '申请换货中', '5' => '商家已同意换货，等待提交邮寄单号',
            '6' => '换货货物返回中', '7' => '商家已收货', '8' => '申请退货中', '9' => '商家已同意退货，等待提交邮寄单号', '10' => '退货货物返回中',
            '11' => '退货完成', '12' => '商家已拒绝退货', '13' => '商家已拒绝换货', '14' => '商家重新发货', '15' => '买家已签收', '16' => '商家已重新安排发货'];
        return $state[$this->attributes['state']];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function orderSon()
    {
        return $this->belongsTo(OrderSons::class, 'order_son_id');
    }

}
