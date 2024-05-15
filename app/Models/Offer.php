<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'name_ar',
        'description_ar',
        'photo_id',
        'type',
        'percent_limited',
        'value',
        'start_at',
        'expires_at',
        'enabled',
        'count',
    ];
    protected $with = ['services','photo'];


    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
    public function photo(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }
}
