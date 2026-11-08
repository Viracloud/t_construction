@extends('front.layouts.master')

@section('seo_title', 'Page Not Found | '.($global_setting->site_name ?? config('app.name')))
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">Page Not Found</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">404</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<section class="container py-24 pt-5 text-center">
    <div class="card p-4 p-md-5 border-0 rounded-4 shadow-lg bg-white">
        <div class="card-body">
            <p class="mb-4">Sorry, the page you are looking for does not exist or has been moved.</p>
            <a href="{{ route('home') }}" class="primary-btns">Back to Home</a>
            <a href="{{ route('services') }}" class="primary-btns ms-2">Our Services</a>
            <a href="{{ route('contact') }}" class="primary-btns ms-2">Contact Us</a>
        </div>
    </div>
</section>
@endsection
