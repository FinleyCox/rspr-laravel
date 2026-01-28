@extends('layouts.app')

@section('title', 'Riso×Pro - サイトについて')

@section('content')
<div class="layout">
    @include('partials.sidebar')
    <main class="content">
        <section id="about">
            <h2>サイトについて</h2>
            <p>このサイトは有志によって作成・管理されているサイトです</p>
            <p><a href="{{ route('home') }}">ホームに戻る</a></p>
        </section>
    </main>
</div>
@endsection
