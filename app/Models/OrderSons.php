<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSons extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id','size_id','quantity','categories_id', 'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function attr()
    {
        return $this->belongsTo(ProductAttr::class,'size_id');
    }
}
