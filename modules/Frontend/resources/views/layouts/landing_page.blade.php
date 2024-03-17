<!DOCTYPE html>
<html class="js" lang="{{ app()->getLocale() }}" dir="{{ get_direction() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <title>{{ get_config("title_".app()->getLocale()) }}
        - @yield('title', get_config("title_".app()->getLocale()))</title>

    @yield('metas')

    <script nonce="{{ csp_nonce() }}">
        if (typeof window.functions == 'undefined') {
            window.functions = {}
        }
        window.functions.csp_nonce = "{{ csp_nonce() }}";
    </script>
</head>

<body>
<header class="header">
    <div class="container">
        <div class="header-components">
            <a href="{{ route('home') }}" title="{{ get_config("title_".app()->getLocale()) }}" class="header-logo">
                <img src="{{ get_logo() }}" width="200" alt="{{ get_config("title_".app()->getLocale()) }}">
            </a>
            <nav class="menu-list">
                @if(!empty($sub_pages))
                    <ul class="main-menu-list list-plain">
                        @foreach($sub_pages as $page)
                            @php
                                $title = $page->subtitle ?? $page->title;
                            @endphp
                            <li><a href="#section-{{ $page->id }}" title="{{ $title }}" class="item">{{ $title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </nav>
            <ul class="toolbar-menu list-plain" id="toolbar-menu">
                @include('frontend::partials.language_switcher', ['slug' => $page->slug ?? '' ])
            </ul>
        </div>
    </div>
</header>
<main class="wrapper">
    @yield('content')
</main>
<footer class="footer">
    <div class="container">
        <div class="sub-footer">
            {{--            <a href="https://progmix.dev/" title="ProgmiX" class="progmix-logo" target="_blank"--}}
            {{--               rel="noreferrer noopener">--}}
            {{--                {{ __('messages.powered_by') }}--}}
            {{--                <img src="https://progmix.dev/progmix_logo.svg" alt="ProgmiX" width="70px" height="20px">--}}
            {{--            </a>--}}
            <div class="copy-rights">{{ __('messages.copy_rights') }}</div>
        </div>
    </div>
</footer>
</body>

{{ Vite::useBuildDirectory('front') }}
@vite(['modules/Frontend/resources/assets/js/landing-page.js'])
</html>
