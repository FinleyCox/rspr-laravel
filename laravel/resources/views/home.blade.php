@php
    $visitCount = $visitCount ?? 0;
    $adultMode = $adultMode ?? false;
    $categoryRouteName = $adultMode ? 'adult.categories.show' : 'categories.show';
    $routeParamsBase = $adultMode ? ['adult' => 1] : [];
@endphp
@extends('layouts.app')

@section('title', 'Riso×Pro - Home')
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
    <!-- サイドバー -->
    @include('partials.sidebar')
    <!-- 真ん中 -->
    <main class="content">
        @php
            $categoryList = $categories ?? collect();
            $illustCategories = $categoryList->where('type', '0');
            $novelCategories = $categoryList->where('type', '1');
        @endphp
        <section id="about">
            <h2>サイトについて</h2>
            <p>このサイトは、Riso×Proのメンバーが作品を公開するサイトです。</p>
        </section>
        @if(isset($latestInfos) && $latestInfos->count() > 0)
        <section id="info">
            <h2>お知らせ</h2>
                <ul class="info-list">
                    @foreach($latestInfos as $info)
                        <li>
                            <span class="date">{{ $info->created_at->format('Y/m/d') }}</span>
                            <span class="content">{{ Str::limit($info->content, 50) }}</span>
                        </li>
                    @endforeach
                </ul>
            <p><a href="{{ route('info') }}">お知らせ一覧へ</a></p>
        @endif
        </section>
        <section id="illust-section">
            <h2>イラスト置き場</h2>
            <ul class="illust-list" id="illust-list">
                {{-- カテゴリはDBから表示 --}}
                @forelse ($illustCategories as $category)
                    @php $params = array_merge(['slug' => $category->slug], $routeParamsBase); @endphp
                    <li><span class="marker-square">■</span><a href="{{ route($categoryRouteName, $params) }}">{{ $category->name }}</a></li>
                @empty
                    <li>カテゴリがありません。</li>
                @endforelse
            </ul>
        </section>
        <section id="novel-section">
            <h2>小説置き場</h2>
            <ul class="novel-list" id="novel-list">
                @forelse ($novelCategories as $category)
                    @php $params = array_merge(['slug' => $category->slug], $routeParamsBase); @endphp
                    <li><span class="marker-circle">◻︎</span><a href="{{ route($categoryRouteName, $params) }}">{{ $category->name }}</a></li>
                @empty
                    <li>カテゴリがありません。</li>
                @endforelse
            </ul>
        </section>
        <section id="members-section">
            <h2>参加メンバー</h2>
            <ul class="member-list" id="member-list">
                @forelse ($members ?? [] as $member)
                    <li>
                        <a href="{{ route('members.show', array_merge(['slug' => $member->slug], $routeParamsBase)) }}" target="_blank" rel="noopener" class="member-banner-link">
                            @if ($member->banner_path)
                                <img src="{{ asset($member->banner_path) }}" alt="（バナー）{{ $member->display_name }}作品ページへ">
                            @else
                                {{ $member->display_name }}
                            @endif
                        </a>
                    </li>
                @empty
                    <li>メンバー情報がありません。</li>
                @endforelse
            </ul>
            <button class="show-more" data-target="#member-list" aria-expanded="false" type="button">もっと見る</button>
        </section>
    </main>
</div>
@endsection
