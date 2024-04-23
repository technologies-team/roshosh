<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartService extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'cart_id',
        'service_id',
        'location_id',
        'coupon_id',
        'price',
        'quantity',
        'service_time',
    ];
}
