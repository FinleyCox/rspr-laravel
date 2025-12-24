@extends('layouts.app')

@section('title', 'リゾプロ - カテゴリー')
@section('body_class', 'home')

@section('content')
@php
    $visitCount = $visitCount ?? 0;
    $categoryName = $category->name ?? 'カテゴリ';
    $categoryType = (string)($category->type ?? '0');
    $popupImage = $popupImage ?? null;
@endphp
<div class="midi-player">
    <button id="midi-toggle">♪ BGM ON</button>
    <audio id="bgm" loop>
        <source src="{{ asset('midi/opening.mid') }}" type="audio/midi">
        ブラウザによっては再生されない場合があります。
    </audio>
</div>
<div class="layout">
    <main class="content">
        <section id="illust-section">
            <h2>{{ $categoryName }}</h2>
            <p>{{ $category->description }}</p>
            <ul class="illust-list" id="illust-list">
                @forelse ($members as $member)
                    <li class="member-card">
                        <div class="member-card__header">
                            <span class="marker-square">■</span>
                            <a href="{{ route('members.show', ['slug' => $member->slug]) }}" target="_blank" rel="noopener">
                                {{ $member->display_name }}のページへ
                            </a>
                        </div>
                        <ul class="member-card__works">
                            @foreach ($member->works as $work)
                                @php
                                    $isNovel = (string)$work->type === '1';
                                    $markerClass = $isNovel ? 'marker-circle' : 'marker-square';
                                    $markerSymbol = $isNovel ? '①' : '■';
                                @endphp
                                <li>
                                    <span class="{{ $markerClass }}">{{ $markerSymbol }}</span>
                                    <a
                                        href="{{ route('categories.show', ['slug' => $category->slug, 'popup' => $work->slug]) }}"
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
