<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
protected $fillable=[
    'total_price','total_discount','total_fee','user_id','status','payment_method'
];

}
