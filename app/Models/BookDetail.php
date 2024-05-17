<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereDate(string $string, \Carbon\Carbon|\Illuminate\Support\Carbon $currentDate)
 */
class BookDetail extends Model
{
protected $fillable=['service_name','location','vehicle','coupon','service_time'];
    use HasFactory;
}
