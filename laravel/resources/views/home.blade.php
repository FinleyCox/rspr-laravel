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
        <section id="illust-section">
            <h2>イラスト置き場</h2>
            <ul class="illust-list" id="illust-list">
                <li><span class="marker-square">■</span><a href="illust/illust01.html">リゾプロエロ</a></li>
                <li><span class="marker-square">■</span><a href="illust/illust02.html">手コキ</a></li>
                <li><span class="marker-square">■</span><a href="illust/illust03.html">女体化</a></li>
            </ul>
            <button class="show-more" data-target="#illust-list" aria-expanded="false" type="button">もっと見る</button>
        </section>
        <section id="novel-section">
            <h2>小説置き場</h2>
            <ul class="novel-list" id="novel-list">
                <li><span class="marker-circle">①</span><a href="novel/novel01.html">短編「リゾプロ最高ー！」</a></li>
                <li><span class="marker-circle">②</span><a href="novel/novel02.html">中編「XP大好き！」</a></li>
                <li><span class="marker-circle">③</span><a href="novel/novel03.html">SS「エロ柱」</a></li>
            </ul>
            <button class="show-more" data-target="#novel-list" aria-expanded="false" type="button">もっと見る</button>
        </section>
        <section id="members-section">
            <h2>参加メンバー</h2>
            <ul class="member-list" id="member-list">
                <li>
                    <a href="{{ route('members.beeskneeswanker.a01a') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker.a01a') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker.a01a') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker.a01a') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker.a01a') }}" target="_blank" rel="noopener" class="member-banner-link">
                        <img src="{{ asset('img/members/beeskneeswanker/banner.svg') }}" alt="（バナー）スラブ紹介ページへ">
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.beeskneeswanker.a01a') }}" target="_blank" rel="noopener" class="member-banner-link">
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
