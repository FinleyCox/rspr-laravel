<?php

namespace App\Services;

use App\Models\VisitCount;
use Illuminate\Support\Facades\DB;

class VisitCounter
{
    /**
     * Increment the global visit counter and return the new value.
     */
    public function increment(): int
    {
        return DB::transaction(function () {
            $record = VisitCount::lockForUpdate()->first();

            if (! $record) {
                $record = VisitCount::create(['count' => 1]);

                return $record->count;
            }

            $record->increment('count');

            return $record->refresh()->count;
        });
    }

    /**
     * Get the current visit count without modifying it.
     */
    public function current(): int
    {
        return VisitCount::value('count') ?? 0;
    }
}
