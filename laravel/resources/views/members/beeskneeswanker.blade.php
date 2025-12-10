@extends('layouts.app')

@section('title', 'beeskneeswanker')
@section('body_class', 'member-page')

@section('content')
@php
    $illusts = [
        [
            'slug' => 'illust01',
            'title' => 'リゾプロエロ',
            'image' => asset('img/members/beeskneeswanker/beeskneeswanker_0.jpg'),
        ],
        [
            'slug' => 'illust02',
            'title' => '手コキ',
            'image' => asset('img/members/beeskneeswanker/beeskneeswanker_1.jpg'),
        ],
    ];
    $novels = [

    ];
    $popupKey = request('popup');
    $popupImage = collect($illusts)->firstWhere('slug', $popupKey)['image'] ?? null;
@endphp

<div class="member-profile">
    {{-- todo:できれば名前とか自動にしたい テーブル作るかな --}}
    <h4 class="member-name">スラブのページ</h4>
    @if (count($illusts) > 0)
    <section>
        <h2>イラスト</h2>
        <ul class="illust-list">
            @foreach ($illusts as $illust)
                <li>
                    <span class="marker-square">■</span>
                    <a
                        href="{{ route('members.beeskneeswanker', ['popup' => $illust['slug']]) }}"
                        data-popup-image="{{ $illust['image'] }}"
                        data-popup-slug="{{ $illust['slug'] }}"
                    >
                        {{ $illust['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
    @endif

    @if (count($novels) > 0)
    <section>
        <h2>小説</h2>
        <ul class="novel-list">
            @foreach ($novels as $novel)
                <li>
                    <span class="marker-circle">②</span>
                    <a href="{{ $novel['link'] }}">{{ $novel['title'] }}</a>
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
