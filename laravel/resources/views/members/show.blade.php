@php
    // 作品タイプで表示マーカーを変えるための簡易判定
    $popupImage = $popupImage ?? null;
    $adultMode = $adultMode ?? false;
    $routeParamsBase = $adultMode ? ['adult' => 1] : [];
@endphp
@extends('layouts.app')

@section('title', 'Riso×Pro - メンバー')
@section('body_class', $adultMode ? 'member-page adult' : 'member-page')

@section('content')

<div class="member-profile">
    <h4 class="member-name">{{ $member->display_name }}のページ</h4>

    @if (($illustWorks ?? collect())->count() > 0 || ($novelWorks ?? collect())->count() > 0)
        @if (($illustWorks ?? collect())->count() > 0)
        <section>
            <h2>イラスト</h2>
            <ul class="illust-list">
                @foreach ($illustWorks as $work)
                    <li>
                        <span class="marker-square">■</span>
                        <a
                            href="{{ route('members.show', array_merge(['slug' => $member->slug, 'popup' => $work->slug], $routeParamsBase)) }}"
                            data-popup-images="{{ json_encode(array_map('asset', $work->asset_paths ?? [$work->asset_path]), JSON_UNESCAPED_SLASHES) }}"
                            data-popup-slug="{{ $work->slug }}"
                        >
                            {{ $work->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
        @endif

        @if (($novelWorks ?? collect())->count() > 0)
        <section>
            <h2>小説</h2>
            <ul class="illust-list">
                @foreach ($novelWorks as $work)
                    <li>
                        <span class="marker-circle">◻︎</span>
                        <a
                            href="{{ route('members.show', array_merge(['slug' => $member->slug, 'popup' => $work->slug], $routeParamsBase)) }}"
                            data-popup-images="{{ json_encode(array_map('asset', $work->asset_paths ?? [$work->asset_path]), JSON_UNESCAPED_SLASHES) }}"
                            data-popup-slug="{{ $work->slug }}"
                        >
                            {{ $work->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
        @endif
    @else
        <p>作品がまだありません。</p>
    @endif
    <p><a href="{{ $adultMode ? route('adult.home') : route('home') }}">ホームへ戻る</a></p>
</div>

<div id="image-modal" class="image-modal" data-show="{{ $popupImage ? '1' : '0' }}" data-images="{{ $popupImage ? json_encode(is_array($popupImage) ? array_map('asset', $popupImage) : [asset($popupImage)], JSON_UNESCAPED_SLASHES) : '[]' }}">
    <div class="image-modal__backdrop"></div>
    <div class="image-modal__content">
        <button class="image-modal__close" type="button">×</button>
        <div class="image-modal__image-container" style="display: flex; flex-direction: column; gap: 10px; align-items: center; overflow-y: auto; max-height: 80vh;">
            {{-- Javascriptで複数画像が挿入されます --}}
        </div>
    </div>
</div>
@endsection
