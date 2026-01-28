@extends('layouts.app')

@section('title', 'Riso×Pro - お問い合わせ')

@section('content')
<div class="layout">
    @include('partials.sidebar')
    <main class="content">
        <section id="contact">
            <h2>お問い合わせ</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="post" class="contact-form">
                @csrf
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}">
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="message">お問い合わせ内容</label>
                    <textarea name="message" id="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit">送信</button>
            </form>
            <p><a href="{{ route('home') }}">ホームに戻る</a></p>
        </section>
    </main>
</div>
@endsection
