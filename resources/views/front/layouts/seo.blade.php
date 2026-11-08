@php
    /*
     | Central SEO head tags. Pages can override with:
     |   @section('seo_title', '...')        @section('seo_description', '...')
     |   @section('og_image', 'full url')    @section('og_type', 'article')
     |   @section('robots', 'noindex, follow')   @section('canonical', 'full url')
     | and add page-specific JSON-LD with @push('schema').
     */
    $siteName = $global_setting->site_name ?: config('app.name');
    $decode = fn ($v) => html_entity_decode(trim($v), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    $seoTitle = $__env->hasSection('seo_title')
        ? $decode($__env->yieldContent('seo_title'))
        : (isset($page_data) && filled($page_data->seo_title ?? null) ? $page_data->seo_title : $siteName);

    $seoDescription = $__env->hasSection('seo_description')
        ? $decode($__env->yieldContent('seo_description'))
        : (isset($page_data) && filled($page_data->seo_meta_description ?? null) ? $page_data->seo_meta_description : '');

    // Canonical always uses the main site address from APP_URL (https, with/without www as set there),
    // so http://, www. or IP versions of a page are never treated as separate pages.
    $siteRoot = rtrim(config('app.url') ?: url('/'), '/');
    $path = trim(request()->path(), '/');
    $page = (int) request()->query('page', 1);
    $canonical = $__env->hasSection('canonical')
        ? $decode($__env->yieldContent('canonical'))
        : $siteRoot.($path === '' ? '/' : '/'.$path).($page > 1 ? '?page='.$page : '');

    // Filtered / searched URLs should not be indexed. Ad and analytics tracking parameters
    // (Google Ads gclid, utm_*, Facebook fbclid ...) are ignored so ad landing pages stay indexable.
    $ignoredParams = ['page', 'gclid', 'gbraid', 'wbraid', 'gad_source', 'gad_campaignid', 'fbclid', 'msclkid', 'ref'];
    $extraQuery = collect(request()->query())
        ->reject(fn ($v, $k) => in_array($k, $ignoredParams, true) || str_starts_with($k, 'utm_'))
        ->isNotEmpty();
    $robots = $__env->hasSection('robots')
        ? $decode($__env->yieldContent('robots'))
        : ($extraQuery ? 'noindex, follow' : 'index, follow, max-image-preview:large');

    $defaultOgImage = $global_setting->og_image ? asset('uploads/'.$global_setting->og_image) : asset('uploads/'.$global_setting->logo_1);
    $ogImage = $__env->hasSection('og_image') ? $decode($__env->yieldContent('og_image')) : '';
    // A page whose item has no image would otherwise point to ".../uploads/"
    if ($ogImage === '' || str_ends_with($ogImage, '/uploads/') || str_ends_with($ogImage, '/uploads')) {
        $ogImage = $defaultOgImage;
    }
    $ogType = $__env->hasSection('og_type') ? $decode($__env->yieldContent('og_type')) : 'website';
@endphp
<title>{{ $seoTitle }}</title>
@if($seoDescription)
<meta name="description" content="{{ $seoDescription }}">
@endif
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonical }}">
@if($global_setting->google_site_verification)
<meta name="google-site-verification" content="{{ $global_setting->google_site_verification }}">
@endif

<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="en_AU">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:title" content="{{ $seoTitle }}">
@if($seoDescription)
<meta property="og:description" content="{{ $seoDescription }}">
@endif
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
@if($seoDescription)
<meta name="twitter:description" content="{{ $seoDescription }}">
@endif
<meta name="twitter:image" content="{{ $ogImage }}">

@if(request()->is('/') || request()->is('about') || request()->is('contact'))
@php
    $phone = $global_setting->top_bar_phone ?: $global_setting->footer_phone;
    $email = $global_setting->top_bar_email ?: $global_setting->footer_email;
    $business = [
        '@context' => 'https://schema.org',
        '@type' => $global_setting->business_type ?: 'GeneralContractor',
        '@id' => url('/').'#business',
        'name' => $siteName,
        'url' => url('/'),
        'logo' => asset('uploads/'.$global_setting->logo_1),
        'image' => $ogImage,
        'telephone' => $phone ?: null,
        'email' => $email ?: null,
        'priceRange' => '$$',
        'address' => array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $global_setting->business_street ?: ($global_setting->top_bar_address ?: null),
            'addressLocality' => $global_setting->business_city ?: null,
            'addressRegion' => $global_setting->business_state ?: null,
            'postalCode' => $global_setting->business_postcode ?: null,
            'addressCountry' => $global_setting->business_country ?: 'AU',
        ]),
        'areaServed' => collect(explode(',', (string) $global_setting->business_area_served))
            ->map(fn ($a) => trim($a))->filter()->map(fn ($a) => ['@type' => 'City', 'name' => $a])->values()->all() ?: null,
        'openingHours' => collect(explode(',', (string) $global_setting->business_opening_hours))
            ->map(fn ($h) => trim($h))->filter()->values()->all() ?: null,
        'sameAs' => collect([
            $global_setting->footer_facebook ?: $global_setting->top_bar_facebook,
            $global_setting->footer_instagram ?: $global_setting->top_bar_instagram,
            $global_setting->footer_twitter ?: $global_setting->top_bar_twitter,
            $global_setting->footer_linkedin ?: $global_setting->top_bar_linkedin,
        ])->filter(fn ($u) => is_string($u) && str_starts_with($u, 'http') && !preg_match('#^https?://(www\.)?[a-z]+\.com/?$#i', $u))->values()->all() ?: null,
    ];
    if ($global_setting->business_latitude && $global_setting->business_longitude) {
        $business['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => (float) $global_setting->business_latitude, 'longitude' => (float) $global_setting->business_longitude];
    }
    $business = array_filter($business, fn ($v) => $v !== null && $v !== []);
@endphp
<script type="application/ld+json">{!! json_encode($business, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@if(request()->is('/'))
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'WebSite', 'name' => $siteName, 'url' => url('/')], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endif
@endif
@stack('schema')

@if($global_setting->google_tag_id || $global_setting->google_ads_id)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $global_setting->google_tag_id ?: $global_setting->google_ads_id }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    @if($global_setting->google_tag_id)
    gtag('config', @json($global_setting->google_tag_id));
    @endif
    @if($global_setting->google_ads_id)
    gtag('config', @json($global_setting->google_ads_id));
    @endif
</script>
@endif
