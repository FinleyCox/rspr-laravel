<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'entrance')->name('entrance');

Route::view('/home', 'home')->name('home');

Route::prefix('members')->group(function () {
    Route::view('/beeskneeswanker/A-01a', 'members.beeskneeswanker.A-01a')
        ->name('members.beeskneeswanker.a01a');
});
