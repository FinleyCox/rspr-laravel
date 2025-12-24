<?php

use App\Services\VisitCounter;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

Route::get('/', function (VisitCounter $counter) {
    $counter->increment();

    return view('entrance');
})->name('entrance');

Route::get('/home', function (VisitCounter $counter) {
    $categories = Category::orderBy('id')->get();
    return view('home', [
        'visitCount' => $counter->current(),
        'categories' => $categories,
    ]);
})->name('home');

Route::prefix('categories')->group(function () {
    Route::get('/{slug}', function (VisitCounter $counter, string $slug) {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categoryId = $category->id;
        // カテゴリIDが一致する作品だけを持つメンバーを取得
        $members = Member::with(['works' => function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        }])->whereHas('works', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->get();

        return view('pages.category', [
            'visitCount' => $counter->current(),
            'category' => $category,
            'members' => $members,
        ]);
    })->name('categories.show');
});

Route::prefix('members')->group(function () {
    Route::view('/gate', 'members.gate')->name('members.gate');
    Route::view('/beeskneeswanker', 'members.beeskneeswanker')
        ->name('members.beeskneeswanker');
    Route::get('/{slug}', function (string $slug) {
        $viewName = "members.{$slug}";
        abort_unless(View::exists($viewName), 404);
        return view($viewName);
    })->name('members.show');
});
