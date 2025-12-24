<?php

use App\Services\VisitCounter;
use App\Models\Category;
use App\Models\Member;
use App\Models\Work;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

Route::get('/', function (VisitCounter $counter) {
    $counter->increment();

    return view('entrance');
})->name('entrance');

Route::get('/home', function (VisitCounter $counter) {
    $categories = Category::orderBy('id')->get();
    $members = Member::orderBy('id')->get();
    return view('home', [
        'visitCount' => $counter->current(),
        'categories' => $categories,
        'members' => $members,
    ]);
})->name('home');

Route::prefix('categories')->group(function () {
    Route::get('/{slug}', function (VisitCounter $counter, string $slug) {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categoryId = $category->id;
        $categoryType = $category->type;
        // カテゴリIDが一致する作品だけを持つメンバーを取得
        $members = Member::with(['works' => function ($query) use ($categoryId, $categoryType) {
            $query->where('category_id', $categoryId);
            // 同じカテゴリ番号でもイラスト／小説で混ざらないようにする
            if ($categoryType !== null && $categoryType !== '') {
                $query->where('type', $categoryType);
            }
        }])->whereHas('works', function ($query) use ($categoryId, $categoryType) {
            $query->where('category_id', $categoryId);
            if ($categoryType !== null && $categoryType !== '') {
                $query->where('type', $categoryType);
            }
        })->get();
        // popup用にslug一致の画像を特定
        $popupSlug = request('popup');
        $popupImage = null;
        if ($popupSlug) {
            $popupImage = $members
                ->flatMap->works
                ->firstWhere('slug', $popupSlug)?->asset_path;
        }

        return view('pages.category', [
            'visitCount' => $counter->current(),
            'category' => $category,
            'members' => $members,
            'popupImage' => $popupImage ? asset($popupImage) : null,
        ]);
    })->name('categories.show');
});

Route::prefix('members')->group(function () {
    Route::view('/gate', 'members.gate')->name('members.gate');
    Route::get('/{slug}', function (string $slug) {
        $member = Member::where('slug', $slug)->firstOrFail();
        $works = Work::where('member_id', $member->id)->get();
        $popupImage = null;
        $popupSlug = request('popup');
        if ($popupSlug) {
            $popupImage = $works->firstWhere('slug', $popupSlug)?->asset_path;
        }
        return view('members.show', [
            'member' => $member,
            'works' => $works,
            'popupImage' => $popupImage ? asset($popupImage) : null,
        ]);
    })->name('members.show');
});
