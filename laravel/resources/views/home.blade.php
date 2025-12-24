@extends('layouts.app')

@section('title', 'リゾプロ - Home')
@section('body_class', 'home')

@section('content')
@php
    $visitCount = $visitCount ?? 0;
@endphp
<div class="midi-player">
    <button id="midi-toggle">♪ BGM ON</button>
    <audio id="bgm" loop>
        <source src="{{ asset('midi/opening.mid') }}" type="audio/midi">
        ブラウザによっては再生されない場合があります。
    </audio>
</div>
<div class="layout">
    <!-- サイドバー -->
    <aside class="sidebar">
        <h1 class="site-title">リゾプロ</h1>
        <nav class="menu">
            <ul>
                <li><a href="#illust-section">イラスト置き場</a></li>
                <li><a href="#novel-section">小説置き場</a></li>
                <li><a href="#members-section">参加メンバー</a></li>
            </ul>
        </nav>
        <div class="counter-box">
            <div>COUNTER</div>
            <div id="counter">
                あなたは
                <span
                    id="counter-digits"
                    data-count="{{ $visitCount }}"
                    data-digits-base="{{ asset('digits') }}"
                    data-pad="5"
                >
                    {{ $visitCount }}
                </span>
                人目の訪問者です。
            </div>
        </div>
    </aside>
    <!-- 真ん中 -->
    <main class="content">
        @php
            $categoryList = $categories ?? collect();
            $illustCategories = $categoryList->where('type', '0');
            $novelCategories = $categoryList->where('type', '1');
        @endphp
        <section id="illust-section">
            <h2>イラスト置き場</h2>
            <ul class="illust-list" id="illust-list">
                {{-- カテゴリはDBから表示 --}}
                @forelse ($illustCategories as $category)
                    <li><span class="marker-square">■</span><a href="{{ route('categories.show', ['slug' => $category->slug]) }}">{{ $category->name }}</a></li>
                @empty
                    <li>カテゴリがありません。</li>
                @endforelse
            </ul>
        </section>
        <section id="novel-section">
            <h2>小説置き場</h2>
            <ul class="novel-list" id="novel-list">
                @forelse ($novelCategories as $category)
                    <li><span class="marker-circle">①</span><a href="{{ route('categories.show', ['slug' => $category->slug]) }}">{{ $category->name }}</a></li>
                @empty
                    <li>カテゴリがありません。</li>
                @endforelse
            </ul>
        </section>
        <section id="members-section">
            <h2>参加メンバー</h2>
            <ul class="member-list" id="member-list">
                <li>
                    <a href="{{ route('members.beeskneeswanker') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <!-- TODO: データ化して繰り返し生成する -->
            </ul>
            <button class="show-more" data-target="#member-list" aria-expanded="false" type="button">もっと見る</button>
        </section>
    </main>
</div>
@endsection
