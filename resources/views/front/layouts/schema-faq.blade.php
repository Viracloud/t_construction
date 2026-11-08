{{-- Usage: @include('front.layouts.schema-faq', ['faqs' => $all_faqs]) ; items need ->question and ->answer --}}
@if(isset($faqs) && count($faqs))
@push('schema')
@php
    $entities = [];
    foreach ($faqs as $faq) {
        $entities[] = [
            '@type' => 'Question',
            'name' => \App\Support\Seo::text($faq->question, 500),
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => \App\Support\Seo::text($faq->answer, 2000)],
        ];
    }
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $entities], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush
@endif
