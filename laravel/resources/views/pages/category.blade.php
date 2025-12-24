@extends('layouts.app')

@section('title', 'リゾプロ - カテゴリー')
@section('body_class', 'home')

@section('content')
@php
    $visitCount = $visitCount ?? 0;
    $categoryName = $category->name ?? 'カテゴリ';
    $categoryType = (string)($category->type ?? '0');
@endphp
<div class="midi-player">
    <button id="midi-toggle">♪ BGM ON</button>
    <audio id="bgm" loop>
        <source src="{{ asset('midi/opening.mid') }}" type="audio/midi">
        ブラウザによっては再生されない場合があります。
    </audio>
</div>
<div class="layout">
    <main class="content">
        <section id="illust-section">
            <h2>{{ $categoryName }}</h2>
            <p>{{ $category->description }}</p>
            <ul class="illust-list" id="illust-list">
                @forelse ($members as $member)
                    <li class="member-card">
                        <div class="member-card__header">
                            <span class="marker-square">■</span>
                            <a href="{{ route('members.show', ['slug' => $member->slug]) }}" target="_blank" rel="noopener">
                                {{ $member->display_name }}のページへ
                            </a>
                        </div>
                        <ul class="member-card__works">
                            @foreach ($member->works as $work)
                                @php
                                    $isNovel = (string)$work->type === '1';
                                    $markerClass = $isNovel ? 'marker-circle' : 'marker-square';
                                    $markerSymbol = $isNovel ? '①' : '■';
                                @endphp
                                <li>
                                    <span class="{{ $markerClass }}">{{ $markerSymbol }}</span>
                                    {{-- TODO: 作品詳細ページが出来たら route(...) へ差し替え --}}
                                    <a href="{{ asset($work->asset_path) }}" target="_blank" rel="noopener">
                                        {{ $work->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @empty
                    <li>該当作品がありません。</li>
                @endforelse
            </ul>
        </section>
    </main>
</div>
@endsection
