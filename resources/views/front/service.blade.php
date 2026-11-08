@extends('front.layouts.master')

{{-- SEO --}}
@section('seo_title', \App\Support\Seo::title($service->seo_title, $service->title, $global_setting->site_name))
@section('seo_description', \App\Support\Seo::description($service->seo_meta_description, $service->short_description, $service->description))
@section('og_image', asset('uploads/'.$service->image))
@include('front.layouts.schema-breadcrumb', ['items' => [['Services', route('services')], [$service->title, route('service', $service->slug)]]])
@include('front.layouts.schema-faq', ['faqs' => $all_faqs])
@push('schema')
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $service->title, 'description' => \App\Support\Seo::description($service->seo_meta_description, $service->short_description, $service->description), 'image' => asset('uploads/'.$service->image), 'url' => route('service', $service->slug), 'areaServed' => ['@type' => 'City', 'name' => $global_setting->business_city ?: 'Sydney'], 'provider' => ['@type' => $global_setting->business_type ?: 'GeneralContractor', 'name' => $global_setting->site_name, 'url' => url('/'), 'telephone' => $global_setting->top_bar_phone]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $service->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('services') }}" class="text-white text-decoration-none opacity-75">{{ $page_data->page_title }}</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $service->title }}
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-shape">
        <img loading="lazy" decoding="async" src="{{ asset('uploads/shape-01.png') }}" class="shape-1" alt="">
        <img loading="lazy" decoding="async" src="{{ asset('uploads/shape-02.png') }}" class="shape-2" alt="">
    </div>
</section>
@endsection

@section('content')
<section class="service-details-section service-section-gap">
    <div class="container">
        <div class="row g-5">
            <!-- Sidebar Area -->
            <div class="col-lg-4 order-2 order-lg-1">
                <div class="left-sidebar">

                    <!-- Widget: Service List -->
                    <div class="single-wrapper service-list mb-4">
                        <h2 class="title-main">All Services</h2>
                        <ul class="list-unstyled p-0 m-0">
                            @foreach($all_services as $item)
                            <li><a href="{{ route('service', $item->slug) }}" class="{{ $service->id == $item->id ? 'active' : '' }}">{{ $item->title }} <span><i class="fa-solid fa-arrow-right"></i></span></a></li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Widget: Emergency Contact -->
                    @if($service->phone_text != '' || $service->phone_number != '')
                    <div class="single-wrapper contact-area mb-4 p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-box">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="text">
                                @if($service->phone_text != '')
                                <p class="mb-0 text-muted small fw-bold">{{ $service->phone_text }}</p>
                                @endif
                                @if($service->phone_number != '')
                                <a href="tel:{{ $service->phone_number }}" class="phone h5 fw-bold text-dark text-decoration-none">{{ $service->phone_number }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Widget: Quick Contact Form -->
                    <div class="single-wrapper contact-area p-4 mb-4">
                        <div class="content-quick-contact-service">
                            <h2 class="title h5 fw-bold mb-4">Get a free consultation?</h2>
                            <form action="{{ route('service_contact') }}" method="post">
                                @csrf
                                <input type="hidden" name="service_title" value="{{ $service->title }}">
                                <div class="single-quick-action mb-3">
                                    <i class="fa-regular fa-face-smile"></i>
                                    <input type="text" class="form-control" placeholder="Your Name *" name="name" required>
                                </div>
                                <div class="single-quick-action mb-3">
                                    <i class="fa-regular fa-envelope"></i>
                                    <input type="email" class="form-control" placeholder="Your Email *" name="email" required>
                                </div>
                                <div class="single-quick-action mb-4">
                                    <i class="fa-regular fa-message"></i>
                                    <textarea class="form-control" placeholder="Your Message *" name="message" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="tmp-btn btn-primary w-100 hover-icon-reverse">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Send Message</span>
                                        <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-8 order-1 order-lg-2">
                <div class="right-content-area checkout-padding-shadow p-0">
                    <div class="image-section" style="background-image: url({{ asset('uploads/'.$service->image) }})"></div>

                    <div class="p-4 p-md-5 pt-0">
                        <div class="description mb-4">
                            {!! $service->description !!}
                        </div>

                        <!-- Accordion Area -->
                        @if(count($all_faqs) > 0)
                        <div class="faq-content-area mt-4">
                            <div class="accordion" id="accordionExample">

                                <h3 class="fw-700">Service FAQs</h3>

                                @foreach($all_faqs as $item)
                                <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fw-bold py-3" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}">
                                            <i class="fa-solid fa-hard-hat me-3 text-primary"></i> {{ $item->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body bg-light">
                                            <div class="desc mb-4">
                                                {!! nl2br($item->answer) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        @endif

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection