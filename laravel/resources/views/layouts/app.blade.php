<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'リゾプロ')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('head')
</head>
<body class="@yield('body_class', '')">
    @yield('content')
    @php
        $mainJsVersion = @filemtime(public_path('js/main.js')) ?: time();
    @endphp
    <script src="{{ asset('js/main.js') . '?v=' . $mainJsVersion }}"></script>
</body>
</html>
