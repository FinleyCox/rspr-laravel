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

Route::prefix('categories')->group(function () {
    Route::view('/category1', 'pages.category_1')->name('categories.category1');
    Route::view('/category2', 'pages.category_2')->name('categories.category2'); // カテゴリ2用のビューは後で差し替え前提
});

Route::prefix('members')->group(function () {
    Route::view('/gate', 'members.gate')->name('members.gate');
    Route::view('/beeskneeswanker', 'members.beeskneeswanker')
        ->name('members.beeskneeswanker');
});
