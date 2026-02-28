<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Riso×Pro')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logos/icon.jpg') }}">
    @stack('head')
</head>
<body class="@yield('body_class', '')">
    @yield('content')
    @php
        $mainJsVersion = @filemtime(public_path('js/main.js')) ?: time();
    @endphp
    <script src="{{ asset('js/main.js') . '?v=' . $mainJsVersion }}"></script>
    <!-- <div id="scroll-mascot" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; opacity: 0; transition: opacity 0.3s; pointer-events: none; cursor: pointer;">
        <img src="{{ asset('images/scroll_mascot.png') }}" alt="Scroll Mascot" style="width: 120px; height: auto; max-width: 25vw;">
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mascot = document.getElementById('scroll-mascot');
            var lastScrollTop = 0;
            var throttleTimer;
            
            window.addEventListener('scroll', function() {
                // メインマスコットのロジック
                if (window.scrollY > 1) {
                    mascot.style.opacity = '1';
                    mascot.style.pointerEvents = 'auto';
                } else {
                    mascot.style.opacity = '0';
                    mascot.style.pointerEvents = 'none';
                }

                // ランダムマスコット生成ロジック
                var now = Date.now();
                if (!throttleTimer) {
                    throttleTimer = setTimeout(function() {
                        spawnRandomMascot();
                        throttleTimer = null;
                    }, 100); // 最大でも100msごとに生成
                }
            });

            function spawnRandomMascot() {
                // スクロールイベントごとに30%の確率で生成（出すぎないように調整）
                if (Math.random() > 0.3) return;

                var img = document.createElement('img');
                img.src = "{{ asset('images/scroll_mascot.png') }}";
                img.style.position = 'fixed';
                img.style.zIndex = '9998'; // メインマスコットの後ろ
                img.style.pointerEvents = 'none'; // クリック不可（インタラクションなし）
                
                // 50pxから100pxの間でランダムなサイズ
                var size = Math.floor(Math.random() * 50) + 50;
                img.style.width = size + 'px';
                img.style.height = 'auto';
                
                // ランダムな位置
                var x = Math.random() * (window.innerWidth - size);
                var y = Math.random() * (window.innerHeight - size);
                img.style.left = x + 'px';
                img.style.top = y + 'px';
                
                // 初期状態は表示
                img.style.opacity = '0.8';
                img.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                img.style.transform = 'scale(0.5)';

                document.body.appendChild(img);

                // アニメーション実行
                requestAnimationFrame(function() {
                    img.style.transform = 'scale(1)';
                    // ほぼ同時にフェードアウト開始
                    setTimeout(function() {
                        img.style.opacity = '0';
                    }, 500);
                });

                // アニメーション終了後（0.5秒 + 予備時間）に要素を削除
                setTimeout(function() {
                    if (img.parentNode) {
                        img.parentNode.removeChild(img);
                    }
                }, 600);
            }

            mascot.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script> -->
</body>
</html>
