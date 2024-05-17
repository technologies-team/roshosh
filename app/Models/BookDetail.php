<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static whereDate(string $string, \Carbon\Carbon|\Illuminate\Support\Carbon $currentDate)
 */
class BookDetail extends Model
{
protected $fillable=['service_name','location','vehicle','coupon','service_time','finished_at'];
    use HasFactory;
public function book(): BelongsTo
{
  return  $this->belongsTo(Book::class);
}
}
