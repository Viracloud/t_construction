@extends('front.layouts.master')

{{-- SEO --}}
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->forget_password_page_title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->forget_password_page_title }}
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
<section class="auth-section py-5 bg-light">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="auth-card p-5 h-100 bg-white shadow-sm border-0">
                    <form action="{{ route('forget_password_submit') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control custom-input" name="email" placeholder="Email Address">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 auth-btn mb-4">
                            Submit <i class="fa-solid fa-arrow-right-long ms-2"></i>
                        </button>

                        <p class="text-center text-muted mb-0">
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary-orange">Back to Login Page</a>
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection