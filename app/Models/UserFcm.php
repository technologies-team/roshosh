<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserFcm extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id','fcm'
    ];
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
