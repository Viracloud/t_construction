@extends('front.layouts.master')

{{-- SEO --}}
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->dashboard_page_title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->dashboard_page_title }}
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-shape">
        <img src="{{ asset('uploads/shape-01.png') }}" class="shape-1" alt="">
        <img src="{{ asset('uploads/shape-02.png') }}" class="shape-2" alt="">
    </div>
</section>
@endsection

@section('content')
<section class="user-dashboard-section-start py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Sidebar Column -->
            <div class="col-lg-3">
                <div class="user-infor-left-sidebar-dashboard">
                    <div class="dashboard-menu-section">
                        <nav class="dashboard-mainmenu">
                            @include('user.sidebar')
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Content Column -->
            <div class="col-lg-9">
                <div class="dash-board-content-section-wrappper">
                    <div class="single-card-dashboard">
                        <h3 class="title with-border-bottom">Welcome {{ Auth::guard('web')->user()->name }}!</h3>

                        <!-- Info Row -->
                        <div class="row single-contact-information align-items-center">
                            <div class="col-lg-4">
                                <div class="profile-info">Registration Date and Time</div>
                            </div>
                            <div class="col-lg-8">
                                <div class="profile-info">
                                    {{ Auth::guard('web')->user()->created_at->format('d M Y h:i A') }}
                                </div>
                            </div>
                        </div>

                        <!-- Info Row -->
                        <div class="row single-contact-information align-items-center mt-2">
                            <div class="col-lg-4">
                                <div class="profile-info">Name</div>
                            </div>
                            <div class="col-lg-8">
                                <div class="profile-info">{{ Auth::guard('web')->user()->name }}</div>
                            </div>
                        </div>

                        <!-- Info Row -->
                        <div class="row single-contact-information align-items-center mt-2">
                            <div class="col-lg-4">
                                <div class="profile-info">Email</div>
                            </div>
                            <div class="col-lg-8">
                                <div class="profile-info text-primary">{{ Auth::guard('web')->user()->email }}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection