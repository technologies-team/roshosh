<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable=[
        'type','color','make','model','license_plate','vehicle_type','user_id'
    ];
    use HasFactory;
    protected static function booted(): void
    {
        static::addGlobalScope('accessDB', function (Builder $builder) {

            $user = auth()->user();

            if ($user instanceof User) {
                $builder->where("user_id","=",$user->id);

            }
        });
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
