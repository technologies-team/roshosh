<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property mixed $user_id
 */
class Location extends Model
{
    use HasFactory;
    protected $fillable=[
        'title','street1', 'street2', 'country_id', 'city_id' ,'longitude','phone','verified', 'latitude', 'user_id','parking_type','country','city'
    ];
    protected static function booted(): void
    {
        static::addGlobalScope('accessDB', function (Builder $builder) {

            $user = auth()->user();

            if ($user instanceof User) {
                $builder->where("user_id","=",$user->id);
            }
        });
    }
}
