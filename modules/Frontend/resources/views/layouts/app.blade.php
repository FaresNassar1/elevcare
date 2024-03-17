<!DOCTYPE html>
<html class="js" lang="{{ app()->getLocale() }}" dir="{{ get_direction() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ get_config("title_$current_locale") }} - @yield('title', get_config("title_$current_locale"))</title>

    @yield('metas')
    {{-- FAVICON START --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="150x150" href="{{ asset('mstile-150x150.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('android-chrome-512x512.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="KS Lighting">
    <meta name="application-name" content="KS Lighting">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    {{-- FAVICON END --}}

    <link rel="preload" href="{{ asset('front/assets/images/loader.gif') }}" as="image">

    @php
        $assetName = 'inner';
        if (is_home()) {
            $assetName = 'home';
        }
    @endphp
</head>

<body>

    <header class="header">
        <div class="container">
            <div class="header-components ">
                <div class="default-dir logo">
                    <a href="/ar" title="elevcare" class="header-logo">
                        <img src="{{ get_logo() }}" height="80"
                            alt="{{ get_config(" title_$current_locale") }}">
                    </a>
                </div>
                {{-- <nav class="main-menu">
                    {!! $nav !!}
                </nav> --}}
                <nav class="main-menu">
                    <ul>
                        <li class="dropdown"><a href="#">المنتجات</a>
                            <div class="dropdown-content">
                                <a href="#">المصاعد</a>
                                <a href="#">السلالم المتحركة والدرج الكهربائي</a>
                                <a href="#">تكنولوجيا</a>
                                <a href="#">الشهادات</a>
                            </div>
                        </li>
                        <li class="dropdown"><a href="#">الخدمات</a>

                            <div class="dropdown-content">
                                <a href="#">المبيعات</a>
                                <a href="#">التركيب</a>
                                <a href="#">الصيانة</a>
                            </div>
                        </li>

                        <li class="dropdown"><a href="#">مشاريع مرجعية</a>
                            <div class="dropdown-content">
                                <a href="#">منطقة الشمال</a>
                                <a href="#">منطقة الوسط</a>
                                <a href="#">منطقة الجنوب</a>
                            </div>
                        </li>
                        <li class="dropdown"><a href="#">التسعير</a>
                            <div class="dropdown-content">
                                <a href="#"> تسعير المبيعات</a>
                                <a href="#">تسعير الصيانة </a>
                            </div>
                        </li>
                        </li>
                        <li><a href="#">الوظائف</a></li>
                        <li><a href="#">التواصل</a></li>
                    </ul>
                </nav>


                <a class="btn btn-primary nav-btn" href="">تسجيل الدخول</a>

            </div>
        </div>
    </header>

    <main class="wrapper">
        @yield('content')
    </main>
    <span class="scroll-top"><i class="fas fa-angle-double-up"></i></span>

    <footer class="footer section-content">
        <div class="main-footer">
            <div class="container">

                <div class="row">

                    <div class="col-md-4">
                        <ul>
                            <li><a href="">Home</a></li>
                        </ul>
                        <ul>
                            <li><a href=""> About Us
                                </a></li>
                        </ul>
                        <ul>
                            <li><a href=""> Our Partners
                                </a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li><a href="">Services and Products
                                </a></li>
                            <li><a href=""> Our Team

                                </a></li>
                            <li><a href=""> Contact us

                                </a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li><a href="">Contact</a></li>
                            <li><a href="">Al-sawhareh near abu deis
                                </a></li>
                            <li><a href="">(972)-524443395
                                </a></li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>
        <div class="sub-footer">
            <div class="copy-right">
                ©2024 AL-OMDEH MEDICAL SUPPLIESP Ltd. All Rights Reserved.
            </div>
        </div>
    </footer>
</body>

{{ Vite::useBuildDirectory('front') }}
@vite(['modules/Frontend/resources/assets/js/' . $assetName . '.js'])

</html>
