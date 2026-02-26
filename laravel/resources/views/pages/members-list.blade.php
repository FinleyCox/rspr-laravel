@php
    $visitCount = $visitCount ?? 0;
    $adultMode = $adultMode ?? false;
    $routeParamsBase = $adultMode ? ['adult' => 1] : [];
    $homeRoute = $adultMode ? route('adult.home') : route('home');
@endphp
@extends('layouts.app')

@section('title', 'Riso×Pro - 参加メンバー')
@section('body_class', $adultMode ? 'home adult' : 'home')

@section('content')
<div class="layout">
    @includeWhen(!$adultMode, 'partials.sidebar')
    @includeWhen($adultMode, 'partials.adult-sidebar')
    <main class="content">
        <section id="members-section">
            <h1>参加メンバー</h1>
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
        <p><a href="{{ $homeRoute }}">← ホームに戻る</a></p>
    </main>
</div>
@endsection
