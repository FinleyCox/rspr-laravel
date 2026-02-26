@php
    $visitCount = $visitCount ?? 0;
    $adultMode = $adultMode ?? false;
    $categoryRouteName = $adultMode ? 'adult.categories.show' : 'categories.show';
    $routeParamsBase = $adultMode ? ['adult' => 1] : [];
    $homeRoute = $adultMode ? route('adult.home') : route('home');
    $novelCategories = $categories ?? collect();
@endphp
@extends('layouts.app')

@section('title', 'Riso×Pro - 小説置き場')
@section('body_class', $adultMode ? 'home adult' : 'home')

@section('content')
<div class="layout">
    @includeWhen(!$adultMode, 'partials.sidebar')
    @includeWhen($adultMode, 'partials.adult-sidebar')
    <main class="content">
        <section id="novel-section">
            <h1>小説置き場</h1>
            <ul class="novel-list" id="novel-list">
                @forelse ($novelCategories as $category)
                    @php $params = array_merge(['slug' => $category->slug], $routeParamsBase); @endphp
                    <li><span class="marker-circle">◻︎</span><a href="{{ route($categoryRouteName, $params) }}">{{ $category->name }}</a></li>
                @empty
                    <li>カテゴリがありません。</li>
                @endforelse
            </ul>
        </section>
        <p><a href="{{ $homeRoute }}">← ホームに戻る</a></p>
    </main>
</div>
@endsection
