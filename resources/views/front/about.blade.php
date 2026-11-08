@extends('front.layouts.master')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">About Us</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}"
                                    class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                About Us
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
@if($page_data->about_status == 'Show')
<section class="px-3  overflow-hidden">
    <div class="container py-24">
        <div class="row align-items-center g-5">
            <div class="col-md-5">
                <div class="position-relative about-img-wrapper">
                    <img loading="lazy" src="{{ asset('uploads/shape-01.svg') }}" alt="" class="position-absolute about-shape1">
                    <img loading="lazy" src="{{ asset('uploads/'.$about_item->image) }}" class="img-fluid rounded-3 position-relative z-1" alt="{{ $global_setting->site_name }} - construction and renovation work in {{ $global_setting->business_city ?: 'Sydney' }}">
                    <img loading="lazy" src="{{ asset('uploads/shape-02.svg') }}" alt="" class="position-absolute about-shape2">

                    @if($about_item->experience_year != '' || $about_item->experience_text != '')
                    <div class="counter-badge position-absolute bg-white shadow p-4 rounded-3 d-flex align-items-center z-2">
                        <div>
                            @if($about_item->experience_year != '')
                            <h3 class="h2 fw-bold mb-0 text-primary">{{ $about_item->experience_year }}+</h3>
                            @endif
                            @if($about_item->experience_text != '')
                            <p class="small text-muted mb-0">{{ $about_item->experience_text }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{--
                    @if($about_item->youtube_id != '')
                    <a href="https://www.youtube.com/watch?v={{ $about_item->youtube_id }}"
                        class="glightbox video-play-btn about-play-btns  mb-4 me-4 z-30 text-decoration-none">
                        <span class="play-icon shadow-lg">
                            <i class="fa-solid fa-play"></i>
                        </span>
                    </a>
                    @endif
                    --}}
                </div>
            </div>

            <div class="col-md-7">
                <div class="section-title">
                    @if($about_item->subheading != '')
                    <p class="text-primary fw-bold text-uppercase mb-2">
                        {{ $about_item->subheading }}
                    </p>
                    @endif
                    <h2 class="main-title fw-600 mb-4">
                        {!! nl2br($about_item->heading) !!}
                    </h2>
                    <div class="description">
                        {!! nl2br($about_item->text) !!}
                    </div>
                </div>

                <div class="mt-4">
                    @if($about_item->phone_text != '' || $about_item->phone_number != '')
                    <div class="d-flex align-items-center mb-30">
                        <div class="call-icon bg-light p-3 rounded-circle me-3 border">
                            <i class="fa-solid fa-phone-volume text-primary fs-4"></i>
                        </div>
                        <div>
                            @if($about_item->phone_text != '')
                            <p class="text-muted mb-2">{{ $about_item->phone_text }}</p>
                            @endif
                            @if($about_item->phone_number != '')
                            <a href="tel:{{ $about_item->phone_number }}" class="h6 fw-bold text-decoration-none text-dark">{{ $about_item->phone_number }}</a>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($about_item->button_link != '' && $about_item->button_text != '')
                    <a href="{{ $about_item->button_link }}" class="primary-btns hover-icon-reverse">
                        <span class="btn-text-content">
                            <span class="btn-icon-wrapper">
                                <span class="btn-icon"><i class="fa-solid fa-phone"></i></span>
                                <span class="btn-text">{{ $about_item->button_text }}</span>
                            </span>
                        </span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ========= About section end ======== -->
@endif

@if($page_data->service_status == 'Show')
<!-- ========= service section start ======== -->
<section class="services-section px-3">
    <div class="container py-24">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 col-md-7">
                <span class="sub-title">{{ $page_data->service_subheading }}</span>
                <h2 class="main-title">{!! nl2br($page_data->service_heading) !!}</h2>
            </div>
            <div class="col-lg-5 offset-lg-1 col-md-5 mt-3 mt-md-0">
                <p class="description mb-0">
                    {!! nl2br($page_data->service_text) !!}
                </p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-md-6 col-lg-4">
                <div class="service-card p-4 h-100">
                    <div class="card-icon mb-4">
                        <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$service->icon) }}" alt="" width="55">
                    </div>
                    <h3 class="card-title">{{ $service->title }}</h3>
                    <p class="card-text">{!! nl2br($service->short_description) !!}</p>

                    <a href="{{ route('service',$service->slug) }}" class="read-more-btn">
                        <span class="ms-3">Read More</span>
                        <div class="arrow-circle">
                            <span class="arrow-icon">↗</span>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ========= service section end ======== -->
@endif

@if($page_data->testimonial_status == 'Show')
    <!-- =========  Testimonials section Start ======== -->
<section class="testimonial-area py-5 bg-white position-relative">
    <div class="container py-24">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <p class="sub-title">{{ $page_data->testimonial_subheading }}</p>
                <h2 class="main-title">{!! nl2br($page_data->testimonial_heading) !!}</h2>
            </div>
        </div>

        <div class="slider-container-relative position-relative px-md-5">
            <div class="owl-carousel owl-theme testimonial-slider-3">
                @foreach($testimonials as $testimonial)
                <div class="item  border shadow-sm px-40">
                    <div class="testimonial-card py-50 m-2 bg-white h-100">
                        <div class="author-info d-flex align-items-center mb-4">
                            <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$testimonial->image) }}"
                                class="rounded-circle me-3 border-2 border-white shadow-sm size-60"
                                alt="{{ $testimonial->name }}">
                            <div>
                                <h4 class="mb-0 fw-bold">{{ $testimonial->name }}</h4>
                                <p class="text-muted mb-0">{{ $testimonial->designation }}</p>
                            </div>
                        </div>
                        <p class="testimonial-text text-muted mb-3">
                            {!! nl2br($testimonial->comment) !!}
                        </p>
                        <div class="star-rating text-warning small">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
@endif
@endsection