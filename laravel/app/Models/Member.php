<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'display_name',
        'banner_path',
        'links',
    ];

    protected $casts = [
        'links' => 'array',
    ];

    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }
}
