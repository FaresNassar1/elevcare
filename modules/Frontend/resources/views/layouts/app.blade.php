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

                <a href="/ar" title="elevcare" class="header-logo">
                    <img src="{{ get_logo() }}" height="80" alt="{{ get_config(" title_$current_locale") }}">
                </a>

                {{-- <nav class="main-menu">
                    {!! $nav !!}
                </nav> --}}
                <nav class="main-menu">
                    <ul>
                        <li class="dropdown"><a href="#">المنتجات</a>
                            <ul class="dropdown-content">
                                <li><a href="#">المصاعد</a></li>
                                <li><a href="#">السلالم المتحركة والدرج الكهربائي</a></li>
                                <li><a href="#">تكنولوجيا</a></li>
                                <li> <a href="#">الشهادات</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#">الخدمات</a>

                            <ul class="dropdown-content">
                                <li><a href="#">المبيعات</a></li>
                                <li><a href="#">التركيب</a></li>
                                <li><a href="#">الصيانة</a></li>
                            </ul>
                        </li>

                        <li class="dropdown"><a href="#">مشاريع مرجعية</a>
                            <ul class="dropdown-content">
                                <li> <a href="#">منطقة الشمال</a></li>
                                <li> <a href="#">منطقة الوسط</a></li>
                                <li><a href="#">منطقة الجنوب</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#">التسعير</a>
                            <ul class="dropdown-content">
                                <li>
                                    <a href="#"> تسعير المبيعات</a>
                                </li>
                                <li><a href="#">تسعير الصيانة </a></li>
                            </ul>
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
                            <li><a href="">الرئيسية</a></li>
                        </ul>
                        <ul>
                            <li><a href=""> معلومات عنا
                                </a></li>
                        </ul>
                        <ul>
                            <li><a href=""> شركاؤنا
                                </a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li><a href="">الخدمات والمنتجات
                                </a></li>
                            <li><a href=""> فريقنا

                                </a></li>
                            <li><a href=""> اتصل بنا

                                </a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li><a href="">اتصال</a></li>
                            <li><a href="">Al-sawhareh near abu deis
                                </a></li>
                            <li><a class="phone-number" href="">(972)-524443395
                                </a></li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>
        <div class="sub-footer">
            <div class="copy-right">
                جميع الحقوق محفوظة © ٢٠٢٤ مؤسسة العمضة للتوريدات الطبية المحدودة.
            </div>
        </div>
    </footer>
</body>

{{ Vite::useBuildDirectory('front') }}
@vite(['modules/Frontend/resources/assets/js/' . $assetName . '.js'])

</html>
