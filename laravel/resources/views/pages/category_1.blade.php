@extends('layouts.app')

@section('title', 'リゾプロ - カテゴリー1')
@section('body_class', 'home')

@section('content')
@php
    $visitCount = $visitCount ?? 0;
    // カテゴリ1に含めるメンバーと作品（DB化するまでの仮データ）
    $categoryMembers = [
        [
            'name' => 'スラブ',
            'memberRoute' => route('members.beeskneeswanker'),
            'works' => [
                [
                    'title' => 'リゾプロ1',
                    'type' => 'illust',
                    'link' => route('members.beeskneeswanker', ['popup' => 'illust01']),
                ],
                [
                    'title' => 'リゾプロ2',
                    'type' => 'illust',
                    'link' => route('members.beeskneeswanker', ['popup' => 'illust02']),
                ],
            ],
        ],
    ];
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
            <h2>イラスト置き場</h2>
            <ul class="illust-list" id="illust-list">
                @foreach ($categoryMembers as $member)
                    <li class="member-card">
                        <div class="member-card__header">
                            <span class="marker-square">■</span>
                            <a href="{{ $member['memberRoute'] }}" target="_blank" rel="noopener">
                                {{ $member['name'] }}のページへ
                            </a>
                        </div>
                        <ul class="member-card__works">
                            @foreach ($member['works'] as $work)
                                @php
                                    $markerClass = $work['type'] === 'novel' ? 'marker-circle' : 'marker-square';
                                @endphp
                                <li>
                                    <span class="{{ $markerClass }}">{{ $work['type'] === 'novel' ? '①' : '■' }}</span>
                                    <a href="{{ $work['link'] }}" target="_blank" rel="noopener">
                                        {{ $work['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </section>
    </main>
</div>
@endsection
