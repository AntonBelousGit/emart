<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_number',
        'product_id',
        'sub_total',
        'total_amount',
        'coupon',
        'quantity',
        'delivery_charge',
        'payment_method',
        'payment_status',
        'condition',
    ];

    public function info()
    {
        return $this->hasOne(OrderInfo::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
