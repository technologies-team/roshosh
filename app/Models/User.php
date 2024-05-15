<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\PasswordResetToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;
    const ROLE_CUSTOMER = 'customer';
    const ROLE_VENDOR = 'vendor';
    const ROLE_ADMIN = 'admin';
    public const statuses = ['NEW', 'UNVERIFIED', 'ACTIVE', 'SUSPENDED'];
    public const status_new = 'NEW';
    public const status_unverified = 'UNVERIFIED';
    public const status_active = 'ACTIVE';
    public const status_suspended = 'SUSPENDED';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'remember_token',
        'role'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role'
    ];

    public function resetToken(): HasOne
    {
        return $this->hasOne(PasswordResetToken::class, 'email', 'email');    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
    public function toLightWeightArray()
    {

        $result = $this->toArray();
        // $customer = $this->isCustomer();
        return $result;
    }

}
