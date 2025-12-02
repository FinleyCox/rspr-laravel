<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitCount extends Model
{
    protected $fillable = [
        'count',
    ];

    protected $casts = [
        'count' => 'integer',
    ];
}
