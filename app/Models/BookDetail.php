<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
protected $fillable=['service_name','location','vehicle','coupon'];
    use HasFactory;
}
