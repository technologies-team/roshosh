<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable=[
        'type','color','make','model','license_plate','vehicle_type','user_id'
    ];
    use HasFactory;
    protected static function booted()
    {
        static::addGlobalScope('accessDB', function (Builder $builder) {
            $user = auth()->user();
            if ($user instanceof User) {
dd("here");
                $builder->where("user_id","=",$user->id);

            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
