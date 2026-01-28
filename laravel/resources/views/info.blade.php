@extends('layouts.app')

@section('title', 'Riso×Pro - お知らせ')

@section('content')
<div class="layout">
    @include('partials.sidebar')
    <main class="content">
        <section id="info">
            <h2>お知らせ</h2>
            @if($infos->isEmpty())
                <p>お知らせはありません。</p>
            @else
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>日付</th>
                            <th>内容</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($infos as $info)
                            <tr>
                                <td>{{ $info->created_at->format('Y/m/d') }}</td>
                                <td>{!! nl2br(e($info->content)) !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $infos->links() }}
            @endif
            <p><a href="{{ route('home') }}">ホームに戻る</a></p>
        </section>
    </main>
</div>
@endsection
