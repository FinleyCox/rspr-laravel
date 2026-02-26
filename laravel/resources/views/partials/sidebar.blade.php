<aside class="sidebar">
    <h1 class="site-title">Riso×Pro</h1>
    <nav class="menu">
        <ul>
            <li><a href="{{ route('about') }}">サイトについて</a></li>
            <li><a href="{{ route('info') }}">お知らせ</a></li>
            <li><a href="{{ route('illust') }}">イラスト置き場</a></li>
            <li><a href="{{ route('novel') }}">小説置き場</a></li>
            <li><a href="{{ route('members.index') }}">参加メンバー</a></li>
            <li><a href="{{ route('contact') }}">お問い合わせ</a></li>
            @if($adultMode ?? false)
            <li><a href="{{ route('home', ['adult' => 0]) }}">表に戻る</a></li>
            @endif
        </ul>
    </nav>
    <div class="counter-box">
        <div>COUNTER</div>
        <div id="counter">
            あなたは
            <span
                id="counter-digits"
                data-count="{{ $visitCount }}"
                data-digits-base="{{ asset('digits') }}"
                data-pad="5"
            >
                {{ $visitCount }}
            </span>
            人目の訪問者です。
        </div>
    </div>
    <div class="entrance-back">
        <button class="entrance-back__btn" onclick="location.href='{{ route('entrance') }}'">エントランスに戻る</button>
    </div>
</aside>
