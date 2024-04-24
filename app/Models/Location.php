<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable=[
        'title','street1', 'street2', 'country_id', 'city_id' ,'longitude','phone','verified', 'latitude', 'user_id','parking_type','country','city'
    ];
}
