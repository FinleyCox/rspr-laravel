<?php

use App\Services\VisitCounter;
use App\Models\Category;
use App\Models\Member;
use App\Models\Work;
use Illuminate\Support\Facades\View;
use App\Models\Info;
use Illuminate\Support\Facades\Route;

Route::get('/', function (VisitCounter $counter) {
    $counter->increment();

    return view('entrance');
})->name('entrance');

Route::get('/home', function (VisitCounter $counter) {
    $categories = Category::orderBy('id')->get();
    $members = Member::orderBy('id')->get();
    $latestInfos = Info::orderBy('created_at', 'desc')->take(3)->get();
    return view('home', [
        'visitCount' => $counter->current(),
        'adultMode' => false,
        'categories' => $categories,
        'members' => $members,
        'latestInfos' => $latestInfos,
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
            $query->where('is_adult', false);
        }])->whereHas('works', function ($query) use ($categoryId, $categoryType) {
            $query->where('category_id', $categoryId);
            if ($categoryType !== null && $categoryType !== '') {
                $query->where('type', $categoryType);
            }
            $query->where('is_adult', false);
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
            'adultMode' => false,
            'categoryRouteName' => 'categories.show',
            'popupImage' => $popupImage ? asset($popupImage) : null,
        ]);
    })->name('categories.show');
});

Route::prefix('adult')->name('adult.')->group(function () {
    Route::get('/home', function (VisitCounter $counter) {
        $categories = Category::orderBy('id')->get();
        $members = Member::orderBy('id')->get();
        return view('home', [
            'visitCount' => $counter->current(),
            'adultMode' => true,
            'categories' => $categories,
            'members' => $members,
        ]);
    })->name('home');

    Route::get('/categories/{slug}', function (VisitCounter $counter, string $slug) {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categoryId = $category->id;
        $categoryType = $category->type;
        $members = Member::with(['works' => function ($query) use ($categoryId, $categoryType) {
            $query->where('category_id', $categoryId);
            if ($categoryType !== null && $categoryType !== '') {
                $query->where('type', $categoryType);
            }
            $query->where('is_adult', true);
        }])->whereHas('works', function ($query) use ($categoryId, $categoryType) {
            $query->where('category_id', $categoryId);
            if ($categoryType !== null && $categoryType !== '') {
                $query->where('type', $categoryType);
            }
            $query->where('is_adult', true);
        })->get();

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
            'adultMode' => true,
            'categoryRouteName' => 'adult.categories.show',
            'popupImage' => $popupImage ? asset($popupImage) : null,
        ]);
    })->name('categories.show');
});

Route::prefix('members')->group(function () {
    Route::view('/gate', 'members.gate')->name('members.gate');
    Route::get('/{slug}', function (string $slug) {
        $member = Member::where('slug', $slug)->firstOrFail();
        $adultMode = request()->boolean('adult');
        $works = Work::where('member_id', $member->id)
            // 個人ページではバナー画像を作品一覧に含めない
            ->when($member->banner_path, function ($query) use ($member) {
                $query->where('asset_path', '!=', $member->banner_path);
            })
            ->where('is_adult', $adultMode)
            ->get();
        $illustWorks = $works->where('type', '0');
        $novelWorks = $works->where('type', '1');
        $popupImage = null;
        $popupSlug = request('popup');
        if ($popupSlug) {
            $popupImage = $works->firstWhere('slug', $popupSlug)?->asset_path;
        }
        return view('members.show', [
            'member' => $member,
            'works' => $works,
            'illustWorks' => $illustWorks,
            'novelWorks' => $novelWorks,
            'adultMode' => $adultMode,
            'popupImage' => $popupImage ? asset($popupImage) : null,
        ]);
    })->name('members.show');
});

use App\Http\Controllers\PageController;

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/info', [PageController::class, 'info'])->name('info');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
