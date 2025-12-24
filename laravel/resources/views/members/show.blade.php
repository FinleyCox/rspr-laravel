@extends('layouts.app')

@section('title', 'リゾプロ - メンバー')
@section('body_class', 'member-page')

@section('content')
@php
    // 作品タイプで表示マーカーを変えるための簡易判定
    $popupImage = $popupImage ?? null;
@endphp

<div class="member-profile">
    <h4 class="member-name">{{ $member->display_name }}のページ</h4>

    @if ($works->count() > 0)
    <section>
        <h2>作品</h2>
        <ul class="illust-list">
            @foreach ($works as $work)
                @php
                    $isNovel = (string)$work->type === '1';
                    $markerClass = $isNovel ? 'marker-circle' : 'marker-square';
                    $markerSymbol = $isNovel ? '◻︎' : '■';
                @endphp
                <li>
                    <span class="{{ $markerClass }}">{{ $markerSymbol }}</span>
                    <a
                        href="{{ route('members.show', ['slug' => $member->slug, 'popup' => $work->slug]) }}"
                        data-popup-image="{{ asset($work->asset_path) }}"
                        data-popup-slug="{{ $work->slug }}"
                    >
                        {{ $work->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
    @endif
</div>

<div id="image-modal" class="image-modal" data-show="{{ $popupImage ? '1' : '0' }}" data-image="{{ $popupImage }}">
    <div class="image-modal__backdrop"></div>
    <div class="image-modal__content">
        <button class="image-modal__close" type="button">×</button>
        <img src="{{ $popupImage ?? '' }}" alt="作品画像">
    </div>
</div>
@endsection
