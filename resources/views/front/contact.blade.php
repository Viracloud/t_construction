@extends('front.layouts.master')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->page_title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->page_title }}
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
<section class="tmp-get-in-touch-area py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="get-in-touch-wrapper shadow-sm bg-white p-5 text-center rounded-3 h-100 position-relative">
                    <div class="icons mb-4 d-inline-flex align-items-center justify-content-center rounded-circle text-primary border border-primary border-opacity-25 contact-icon-box">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h4 class="title fw-bold mb-3 text-dark">Contact Number</h4>
                    <div class="mb-1">
                        @foreach(preg_split('/\r\n|\r|\n/', trim($page_data->phone_number)) as $phone)
                            @if(trim($phone) != '')
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="text-decoration-none text-muted hover-moving-primary d-block">{{ trim($phone) }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="get-in-touch-wrapper shadow-sm bg-white p-5 text-center rounded-3 h-100 position-relative">
                    <div class="icons mb-4 d-inline-flex align-items-center justify-content-center rounded-circle text-primary border border-primary border-opacity-25 contact-icon-box">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h4 class="title fw-bold mb-3 text-dark">Email Address</h4>
                    <div class="mb-1">
                        @foreach(preg_split('/\r\n|\r|\n/', trim($page_data->email_address)) as $email)
                            @if(trim($email) != '')
                            <a href="mailto:{{ trim($email) }}" class="text-decoration-none text-muted hover-moving-primary d-block">{{ trim($email) }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="get-in-touch-wrapper shadow-sm bg-white p-5 text-center rounded-3 h-100 position-relative">
                    <div class="icons mb-4 d-inline-flex align-items-center justify-content-center rounded-circle text-primary border border-primary border-opacity-25 contact-icon-box">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h4 class="title fw-bold mb-3 text-dark">Office Location</h4>
                    <p class="text-muted mb-0">
                        {!! nl2br(e($page_data->location)) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =========  Get In Touch section End  ======== -->


<!-- =========  Contact section start ======== -->
<section class="contact-section tmp-section-gap py-5 bg-light">
    <div class="container py-24 pt-0">
        <div class="section-inner">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="contact-map h-100 min-vh-50 rounded-3 overflow-hidden shadow-sm">
                        {!! $page_data->map_iframe_code !!}
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contact-form bg-white p-4 p-md-5 rounded-3 shadow-sm">
                        <form action="{{ route('contact_submit') }}" method="post" class="contact-form-style-default">
                            @csrf
                            <h3 class="title fw-bold mb-4">Contact Form</h3>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold"><i class="fa-regular fa-user text-primary me-2"></i> Full Name *</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter your full name" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><i class="fa-regular fa-envelope text-primary me-2"></i> Email Address *</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter your email address" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold"><i class="fa-regular fa-message text-primary me-2"></i> Message *</label>
                                <textarea class="form-control" name="message" rows="4" placeholder="Write your message" required></textarea>
                            </div>

                            <button type="submit"
                                class="btn btn-primary w-100 py-3 fw-bold rounded-2 btn-send">
                                Send Your Message <i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection