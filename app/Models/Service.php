<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{

    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        //
        //
        'title',
        'title_ar',
        'description_ar',
        'description',
        'price',
        'category_id',
        'rewards',
        'photo_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'float',
        'duration' => 'int',
        'rewards' => 'int',
        'category_id' => 'integer',
        'avatar_id'=>'integer'
    ];

    protected $with = ['avatar','category'];


    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
