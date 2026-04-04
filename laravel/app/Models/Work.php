<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'category_id',
        'slug',
        'title',
        'type',
        'is_adult',
        'asset_path',
        'asset_paths',
        'countdown_day',
        'summary',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_adult' => 'boolean',
        'asset_paths' => 'array',
        'countdown_day' => 'integer',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_work');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
