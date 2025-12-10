@extends('layouts.app')

@section('title', 'beeskneeswanker')
@section('body_class', 'member-page')

@section('content')
@php
    $illusts = [
        [
            'slug' => 'illust01',
            'title' => 'リゾプロエロ',
            'link' => url('illust/illust01.html'),
            'image' => asset('img/members/beeskneeswanker/beeskneeswanker_1.jpg'),
        ],
    ];
    $novels = [
        [
            'slug' => 'novel02',
            'title' => '中編「XP大好き！」',
            'link' => url('novel/novel02.html'),
        ],
    ];
    $popupKey = request('popup');
    $popupImage = collect($illusts)->firstWhere('slug', $popupKey)['image'] ?? null;
@endphp

<div class="member-profile">
    <div class="member-hero">
        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="beeskneeswanker banner" class="member-hero__banner">
        <div class="member-hero__thumbs">
            <img src="{{ asset('img/members/beeskneeswanker/beeskneeswanker_1.jpg') }}" alt="beeskneeswanker illustration 1">
            <img src="{{ asset('img/members/beeskneeswanker/beeskneeswanker_2.jpg') }}" alt="beeskneeswanker illustration 2">
            <img src="{{ asset('img/members/beeskneeswanker/beeskneeswanker_3.jpg') }}" alt="beeskneeswanker illustration 3">
        </div>
    </div>

    @if (count($illusts) > 0)
    <section>
        <h2>イラスト</h2>
        <ul class="illust-list">
            @foreach ($illusts as $illust)
                <li>
                    <span class="marker-square">■</span>
                    <a href="{{ $illust['link'] }}">{{ $illust['title'] }}</a>
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
