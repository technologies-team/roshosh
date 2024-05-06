<?php

namespace App\Models;

use App\Http\Requests\VehicleUpdateRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartService extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'cart_id',
        'service_id',
        'location_id',
        'coupon_id',
        'price',
        'quantity',
        'service_time',
        'total_price'
    ];
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
