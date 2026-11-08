<!DOCTYPE html>
<html class="no-js" lang="en-AU" @if($global_setting->layout_direction == 'rtl') dir="rtl" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @include('front.layouts.seo')
    <link rel="icon" type="image/png" href="{{ asset('uploads/'.$global_setting->favicon) }}">

    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@400;700&family=Rubik:wght@400;700&display=swap" rel="stylesheet">

    @include('front.layouts.styles')

    @if($global_setting->layout_direction == 'rtl')
    <link rel="stylesheet" href="{{ asset('dist-front/css/rtl.css') }}">
    @endif

    <style>
        :root {
            --primary-color: {{ $global_setting->theme_color }};
        }
        .text-primary-orange {
            color: {{ $global_setting->theme_color }} !important;
        }
        .about-img-wrapper::before,
        .about-img-wrapper::after,
        .tmp-team-details-area .social-wrapper a:hover,
        .product-tab-btn.active,
        .reply-link,
        .post-comment-btn {
            background-color: {{ $global_setting->theme_color }} !important;
        }
        .product-tab-btn:hover,
        .tmp-breadcrumb-area a:hover,
        .category-link:hover {
            color: {{ $global_setting->theme_color }} !important;
        }
        .reply-input:focus,
        .product-thumb:hover {
            border-color: {{ $global_setting->theme_color }} !important;
        }
    </style>

</head>
<body>
    <header>
        @include('front.layouts.top')
        @include('front.layouts.nav')
        @include('front.layouts.mobile-nav')

        @yield('banner')
    </header>
    <main>
        @yield('content')
    </main>
    @include('front.layouts.footer')
    @include('front.layouts.scripts')
    @stack('scripts')
    @include('front.layouts.tracking')

</body>
</html>