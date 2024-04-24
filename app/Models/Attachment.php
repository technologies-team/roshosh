<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Attachment extends Model
{
    use HasFactory;

    /**
     * @var mixed|string|null
     */
    public mixed $mime_type;
    /**
     * @var false|mixed|string
     */
    public mixed $url;
    protected $fillable = [
        'name',
        'mime_type',
        'path',

    ];
    protected mixed $path;

    // Define a mutator to set the value of path


    protected $appends = [
        'url',
    ];
    public function getUrlAttribute()
    {
        $url = env('APP_URL');
        $url = [$url . '/api', 'attachment', 'download', $this->name];
        $url = implode('/', $url);
        return $url;
    }
}
