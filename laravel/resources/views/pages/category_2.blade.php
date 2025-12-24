@extends('layouts.app')

@section('title', 'リゾプロ - カテゴリー2')
@section('body_class', 'home')

@section('content')
@php
    $visitCount = $visitCount ?? 0;
    // カテゴリ2のコンテンツは未定義のためプレースホルダー
@endphp
<div class="layout">
    <main class="content">
        <section id="illust-section">
            <h2>カテゴリー2</h2>
            <p>カテゴリ2の作品は準備中です。</p>
        </section>
    </main>
</div>
@endsection
