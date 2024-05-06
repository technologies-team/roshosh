<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    const status = ['waiting','inProgress','complete','cancel','reject','schedule'];
    protected $fillable=[
    'total_price','total_discount','total_fee','user_id','status','payment_method','notes'
];
    protected  $with = ['details'];
    public function details(): HasMany
    {
        return $this->hasMany(BookDetail::class);
    }
}
