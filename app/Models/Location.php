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
    /**
     * Check if the given coordinates fall within the boundaries of Dubai.
     *
     * @return bool
     */
    public function isLocationInDubai(): bool
    {
        $latitude = $this->input('lat');
        $longitude = $this->input('lng');

        // Define the boundaries of Dubai (approximate values)
        $dubaiBounds = [
            'min_latitude' => 24.75,
            'max_latitude' => 25.35,
            'min_longitude' => 55.10,
            'max_longitude' => 56.50,
        ];

        // Check if the coordinates fall within the boundaries of Dubai
        return $latitude >= $dubaiBounds['min_latitude'] &&
            $latitude <= $dubaiBounds['max_latitude'] &&
            $longitude >= $dubaiBounds['min_longitude'] &&
            $longitude <= $dubaiBounds['max_longitude'];
    }
}
