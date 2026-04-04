{{-- adult専用サイドバー --}}
<aside class="sidebar">
    <h1 class="site-title">
        <a href="{{ route('adult.home') }}"><img src="{{ asset('img/logos/icon.jpg') }}" alt="Riso×Pro" class="site-header-img sidebar-icon"></a>
    </h1>
    <nav class="menu">
        <ul>
            <li><a href="{{ route('adult.home') }}">ホーム</a></li>
            <li><a href="{{ route('adult.illust') }}">イラスト置き場</a></li>
            <li><a href="{{ route('adult.novel') }}">小説置き場</a></li>
            <li><a href="{{ route('other') }}">その他置き場</a></li>
            <li><a href="{{ route('countdown') }}">カウントダウン</a></li>
            <li><a href="{{ route('adult.members.index') }}">参加メンバー</a></li>
            <li><a href="{{ route('home') }}">表に戻る</a></li>
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
