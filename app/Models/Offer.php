<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
protected $hidden=["start_at",'expires_at','type','percent_limited','enabled','count','pivot'];
    protected static function booted(): void
    {
        static::addGlobalScope('accessDB', function (Builder $builder) {
            $now = Carbon::now();
            $user = auth()->user();
            if ($user instanceof User) {
                if( $user->hasRole("customer")){
                $builder->where('start_at', '<=', $now)
                    ->where('expires_at', '>=', $now)->where("enabled","=",true);
            }}
            else{
                $builder->where('start_at', '<=', $now)
                    ->where('expires_at', '>=', $now)->where("enabled","=",true);
            }
        });
    }


    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }
}
