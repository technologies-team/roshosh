<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BookLog extends Model
{
    use HasFactory;
    protected $fillable=["book_id","user_id","new_status","old_status","reason","notes"];
    public function book(): HasOne{
        return $this->hasOne(Book::class);
    }
    public function user(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
