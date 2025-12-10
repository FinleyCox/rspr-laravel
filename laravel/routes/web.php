<?php

use App\Services\VisitCounter;
use Illuminate\Support\Facades\Route;

Route::get('/', function (VisitCounter $counter) {
    $counter->increment();

    return view('entrance');
})->name('entrance');

Route::get('/home', function (VisitCounter $counter) {
    return view('home', [
        'visitCount' => $counter->current(),
    ]);
})->name('home');

Route::prefix('members')->group(function () {
    Route::view('/beeskneeswanker', 'members.beeskneeswanker.A-01a')
        ->name('members.beeskneeswanker.a01a');
});
