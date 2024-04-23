<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    protected $fillable=[
        'type','color','make','model','license_plate',
    ];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
