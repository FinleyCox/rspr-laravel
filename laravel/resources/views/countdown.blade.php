@extends('layouts.app')

@section('title', 'Riso×Pro - カウントダウン')

@section('content')
<div class="layout">
    @include('partials.sidebar')
    <main class="content">
        <section id="countdown">
            <h2>カウントダウン</h2>
            <p>100からカウントしてイラスト、小説、その他を飾る予定地です。</p>
            
            <div class="countdown-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px; margin-top: 20px;">
                @for ($i = 100; $i >= 1; $i--)
                    <div class="countdown-item" style="border: 1px solid #ccc; padding: 10px; text-align: center; border-radius: 8px;">
                        <span style="font-size: 1.2rem; font-weight: bold; display:block; margin-bottom: 5px;">{{ $i }}</span>
                        @if (isset($countdownWorks) && $countdownWorks->has($i))
                            @foreach ($countdownWorks[$i] as $work)
                                <div style="margin-top: 5px; font-size: 0.9rem;">
                                    <a
                                        href="{{ route('members.show', array_merge(['slug' => $work->member->slug, 'popup' => $work->slug], $routeParamsBase ?? [])) }}"
                                        data-popup-images="{{ json_encode(array_map('asset', $work->asset_paths ?? [$work->asset_path]), JSON_UNESCAPED_SLASHES) }}"
                                        data-popup-slug="{{ $work->slug }}"
                                        style="text-decoration: underline; color: #d05b5b;"
                                        title="{{ $work->member->display_name }}の作品"
                                    >
                                        {{ $work->title }}
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endfor
            </div>

            <p style="margin-top: 30px;"><a href="{{ route('home') }}">ホームに戻る</a></p>
        </section>
    </main>
</div>

<div id="image-modal" class="image-modal" data-show="0" data-images="[]">
    <div class="image-modal__backdrop"></div>
    <div class="image-modal__content">
        <button class="image-modal__close" type="button">×</button>
        <div class="image-modal__image-container" style="display: flex; flex-direction: column; gap: 10px; align-items: center; overflow-y: auto; max-height: 80vh;">
            {{-- Javascriptで複数画像が挿入されます --}}
        </div>
    </div>
</div>
@endsection
