<?php

namespace App\Models;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public const TYPE_CASH = 'cash';
    public const TYPE_PERCENT = 'percent';
    public const TYPE_PERCENT_LIMITED = 'percent_limited';
    public const TYPES = [
        'name',
        'cash',
        'percent',
        'percent_limited',
    ];
    private mixed $type;
    private mixed $value;

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('accessDB', function (Builder $builder) {
            //
            $user = auth()->user();
            if (!$user instanceof User) {
                throw new AuthorizationException();
            }
            //
            $user_id = (int) $user->id;
            $role_id = (int) $user->role_id;
            //


               // $builder->orWhereHas('users', function (Builder $qb) use ($user_id) {
                 //   $qb->where('id', '=', $user_id);
               // });

        });
    }

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'value',
        'start_at',
        'expires_at',
        'enabled',
        'count',
        'clinic_id'
    ];
    protected $casts = [
        'value' => 'json',
        'count' =>'integer'
    ];

    public function apply(float $value): float
    {
        $discount = PHP_FLOAT_MAX;
        if ($this->type !== Coupon::TYPE_CASH) {
            $percent = (int) $this->value['percent'];
            $discount = $value * $percent / 100;
        }
        if ($this->type !== Coupon::TYPE_PERCENT) {
            $discount = min($discount, $this->value['limit']);
        }
        return $value - $discount;
    }
}
