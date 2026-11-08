{{-- Usage: @include('front.layouts.schema-breadcrumb', ['items' => [['Services', route('services')], ['Title', url()->current()]]]) --}}
@push('schema')
@php
    $crumbs = array_merge([[$global_setting->site_name ?: 'Home', route('home')]], $items);
    $list = [];
    foreach ($crumbs as $i => [$name, $url]) {
        $list[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => \App\Support\Seo::text($name, 110), 'item' => $url];
    }
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $list], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush
