@extends('layouts.app')

@section('title', 'Riso×Pro - その他')

@section('content')
<div class="layout">
    @include('partials.sidebar')
    <main class="content">
        <section id="other">
            <h2>それ以外の作品</h2>
            <p>ここにその他の作品が並びます。</p>
            <p><a href="{{ route('home') }}">ホームに戻る</a></p>
        </section>
    </main>
</div>
@endsection
