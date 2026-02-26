@extends('layouts.app')

@section('title', 'Riso×Pro - Entrance')
@section('body_class', 'entrance')

@section('content')
<div class="entrance-wrapper" style="text-align: center;">
    <div class="entrance-box">
        <h1 class="site-title">
            <img src="{{ asset('img/logos/header.jpg') }}" alt="Riso×Pro" class="site-header-img">
        </h1>
        <p class="notice-text">
            ここは有志で運営する同人サイトです。<br>
            二次創作・BL表現などを含む場合があります。<br>
            作品・著作元とは一切関係ありません。<br><br>
            閲覧に問題のない方のみお進みください。
        </p>
        <button onclick="location.href='{{ route('home') }}'" class="enter-button">
            entri
        </button>
    </div>
    <a href="{{ route('members.gate') }}" style="color: #ebf6f7; text-decoration: none; margin-top: 12px; display: inline-block;">
        裏サイト
    </a>
</div>
@endsection
