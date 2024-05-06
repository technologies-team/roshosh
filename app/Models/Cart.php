<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    public mixed $price;

    protected $fillable=['user_id','session_id'];

    protected $with=['cartService'];
    public function cartService(): HasMany
    {
        return $this->hasMany(CartService::class);
    }
}
