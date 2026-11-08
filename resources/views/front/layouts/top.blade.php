@if($global_setting->top_bar_phone != '' || $global_setting->top_bar_email != '')
<section class="top-bar mobile-contact-bar py-2 d-xl-none">
    <div class="container d-flex flex-wrap justify-content-center align-items-center gap-3">
        @if($global_setting->top_bar_phone != '')
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $global_setting->top_bar_phone) }}">
            <i class="bi bi-telephone me-1"></i>{{ $global_setting->top_bar_phone }}
        </a>
        @endif
        @if($global_setting->top_bar_email != '')
        <a href="mailto:{{ $global_setting->top_bar_email }}">
            <i class="bi bi-envelope me-1"></i>{{ $global_setting->top_bar_email }}
        </a>
        @endif
    </div>
</section>
@endif

<section class="top-bar py-2 text-white d-none d-xl-block">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center gap-3">
            @if($global_setting->top_bar_email != '')
            <a href="mailto:{{ $global_setting->top_bar_email }}" class="text-white text-decoration-none">
                <i class="bi bi-envelope me-1"></i> {{ $global_setting->top_bar_email }}
            </a>
            @endif
            @if($global_setting->top_bar_phone != '')
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $global_setting->top_bar_phone) }}" class="border-start ps-3 text-white text-decoration-none">
                <i class="bi bi-telephone me-1"></i> {{ $global_setting->top_bar_phone }}
            </a>
            @endif
            @if($global_setting->top_bar_address != '')
            <span class="border-start ps-3">
                <i class="bi bi-geo-alt me-1"></i> {{ $global_setting->top_bar_address }}
            </span>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="social-links border-end pe-3">
                @if($global_setting->top_bar_facebook != '')
                <a href="{{ $global_setting->top_bar_facebook }}" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                @endif

                @if($global_setting->top_bar_twitter != '')
                <a href="{{ $global_setting->top_bar_twitter }}" class="text-white me-2"><i class="bi bi-twitter-x"></i></a>
                @endif

                @if($global_setting->top_bar_linkedin != '')
                <a href="{{ $global_setting->top_bar_linkedin }}" class="text-white me-2"><i class="bi bi-tiktok"></i></a>
                @endif

                @if($global_setting->top_bar_instagram != '')
                <a href="{{ $global_setting->top_bar_instagram }}" class="text-white"><i class="bi bi-instagram"></i></a>
                @endif
            </div>
        </div>
    </div>
</section>