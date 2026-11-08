@extends('front.layouts.master')

{{-- SEO --}}
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->wishlist_page_title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->wishlist_page_title }}
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
                    <div class="single-card-dashboard shadow-sm bg-white p-4 rounded-3">
                        <h3 class="order-title mb-4">Wishlist</h3>

                        <div class="table-responsive">
                            <table class="table table-borderless align-middle custom-order-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Price (Old)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wishlists as $wishlist)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $wishlist->product->name }}<br>
                                            <a href="{{ route('product', $wishlist->product->slug) }}">See Product</a>
                                        </td>
                                        <td>${{ $wishlist->product->price }}</td>
                                        <td>
                                            @if($wishlist->product->old_price != '')
                                            ${{ $wishlist->product->old_price }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('wishlist_delete', $wishlist->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection