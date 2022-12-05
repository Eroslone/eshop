<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange_goods extends Model
{
    use HasFactory;

    protected  $fillable=['order_son_id','size_id'];

    public function orderSon()
    {
        return $this->hasMany(Order::class);
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
