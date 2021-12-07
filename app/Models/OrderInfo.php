<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class OrderInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'country',
        'address',
        'city',
        'state',
        'note',
        'postcode',
        'sfirst_name',
        'slast_name',
        'sphone',
        'scountry',
        'saddress',
        'scity',
        'sstate',
        'order_id',
        'spostcode'
    ];

//    public function order()
//    {
//        return $this->belongsTo(Order::class,'order_id');
//    }
}
