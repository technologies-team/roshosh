<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    public mixed $name;
    /**
     * @var mixed|string|null
     */
    public mixed $mime_type;
    /**
     * @var false|mixed|string
     */
    public mixed $path;
    protected $fillable = [
        'name',
        'mime_type',
        'path',

    ];
}
