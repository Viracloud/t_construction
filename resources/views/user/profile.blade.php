@extends('front.layouts.master')

{{-- SEO --}}
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->profile_page_title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->profile_page_title }}
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

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="dash-board-content-area-wrappper">

                    <div class="single-card-dashboard shadow-sm bg-white p-4 rounded mb-5">
                        <h3 class="border-bottom pb-3 mb-4 fw-600">Edit Profile</h3>
                        <form action="{{ route('profile_update') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ Auth::guard('web')->user()->name }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">Email *</label>
                                    <input type="email" name="email" class="form-control" value="{{ Auth::guard('web')->user()->email }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">Phone *</label>
                                    <input type="text" name="phone" class="form-control" value="{{ Auth::guard('web')->user()->phone }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">Address *</label>
                                    <input type="text" name="address" class="form-control" value="{{ Auth::guard('web')->user()->address }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">Country *</label>
                                    <input type="text" name="country" class="form-control" value="{{ Auth::guard('web')->user()->country }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">State *</label>
                                    <input type="text" name="state" class="form-control" value="{{ Auth::guard('web')->user()->state }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">City *</label>
                                    <input type="text" name="city" class="form-control" value="{{ Auth::guard('web')->user()->city }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">Zip *</label>
                                    <input type="text" name="zip" class="form-control" value="{{ Auth::guard('web')->user()->zip }}">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">New Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="primary-btns hover-icon-reverse">
                                <span class="btn-text-content">
                                    <span class="btn-icon-wrapper">
                                        <span class="btn-text">Save Changes </span>
                                    </span>
                                </span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection