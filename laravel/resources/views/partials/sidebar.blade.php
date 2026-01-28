<aside class="sidebar">
    <h1 class="site-title">Riso×Pro</h1>
    <nav class="menu">
        <ul>
            <li><a href="{{ route('about') }}">サイトについて</a></li>
            <li><a href="{{ route('info') }}">お知らせ</a></li>
            <li><a href="{{ route('home') }}#illust-section">イラスト置き場</a></li>
            <li><a href="{{ route('home') }}#novel-section">小説置き場</a></li>
            <li><a href="{{ route('home') }}#members-section">参加メンバー</a></li>
            <li><a href="{{ route('contact') }}">お問い合わせ</a></li>
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
</aside>
