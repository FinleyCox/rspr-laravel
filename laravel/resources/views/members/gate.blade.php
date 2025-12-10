@extends('layouts.app')

@section('title', '裏サイトへ')
@section('body_class', 'entrance')

@section('content')
<div class="entrance-box">
    <h1 class="site-title">裏サイト入口</h1>
    <p class="notice-text">
        ここから先は裏サイトです。苦手な方や18歳未満の方は戻るを選んでください。
    </p>
    <button onclick="location.href='{{ route('members.beeskneeswanker') }}'" class="enter-button">
        入る
    </button>
    <button onclick="location.href='{{ route('entrance') }}'" class="enter-button">
        戻る
    </button>
</div>
@endsection
