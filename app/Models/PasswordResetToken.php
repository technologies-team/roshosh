<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{

    public $timestamps = false; // Disable timestamps

    protected $table = 'password_reset_tokens';

    protected $fillable = [
        'email', 'token', 'created_at'
   ] ;


}
