@php
    $visitCount = $visitCount ?? 0;
    $categoryName = $category->name ?? 'カテゴリ';
    $categoryType = (string)($category->type ?? '0');
    $popupImage = $popupImage ?? null;
    $adultMode = $adultMode ?? false;
    $categoryRouteName = $categoryRouteName ?? ($adultMode ? 'adult.categories.show' : 'categories.show');
    $routeParamsBase = $adultMode ? ['adult' => 1] : [];
@endphp
@extends('layouts.app')

@section('title', 'Riso×Pro - カテゴリー')
@section('body_class', $adultMode ? 'home adult' : 'home')

@section('content')
<!-- <div class="midi-player">
    <button id="midi-toggle">♪ BGM ON</button>
    <audio id="bgm" loop>
        <source src="{{ asset('midi/opening.mid') }}" type="audio/midi">
        ブラウザによっては再生されない場合があります。
    </audio>
</div> -->
<div class="layout">
    <main class="content">
        <section id="illust-section">
            <h2>{{ $categoryName }}</h2>
            <p>{{ $category->description }}</p>
            <ul class="illust-list" id="illust-list">
                @forelse ($members as $member)
                    <li class="member-card">
                        <div class="member-card__header">
                            <span class="marker-square">⇨</span>
                            <a href="{{ route('members.show', array_merge(['slug' => $member->slug], $routeParamsBase)) }}" target="_blank" rel="noopener">
                                {{ $member->display_name }}のページへ
                            </a>
                        </div>
                        <ul class="member-card__works">
                            @foreach ($member->works as $work)
                                <li>
                                    <a
                                        href="{{ route($categoryRouteName, array_merge(['slug' => $category->slug, 'popup' => $work->slug], $routeParamsBase)) }}"
                                        data-popup-image="{{ asset($work->asset_path) }}"
                                        data-popup-slug="{{ $work->slug }}"
                                    >
                                        {{ $work->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @empty
                    <li>該当作品がありません。</li>
                @endforelse
            </ul>
        </section>
    </main>
</div>
<div id="image-modal" class="image-modal" data-show="{{ $popupImage ? '1' : '0' }}" data-image="{{ $popupImage }}">
    <div class="image-modal__backdrop"></div>
    <div class="image-modal__content">
        <button class="image-modal__close" type="button">×</button>
        <img src="{{ $popupImage ?? '' }}" alt="作品画像">
    </div>
</div>
@endsection
