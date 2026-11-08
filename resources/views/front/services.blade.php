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
<section class="services-section px-3">
    <div class="container py-24">
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

            <div class="col-lg-12">
                <nav class="pagination-area mt-5 pt-4">
                    <ul class="pagination justify-content-center gap-2 border-0">
                        
                        {{-- Previous Page Link --}}
                        @if ($services->onFirstPage())
                            <li class="page-item disabled"><span class="page-link rounded-circle border-0 shadow-sm text-muted"><i class="fa-solid fa-arrow-left"></i></span></li>
                        @else
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $services->previousPageUrl() }}"><i class="fa-solid fa-arrow-left"></i></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        {{-- Note: This requires the $services->links() logic or manual loop --}}
                        @foreach ($services->getUrlRange(max(1, $services->currentPage() - 2), min($services->lastPage(), $services->currentPage() + 2)) as $page => $url)
                            @if ($page == $services->currentPage())
                                <li class="page-item active"><span class="page-link rounded-circle border-0 shadow-sm">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($services->hasMorePages())
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $services->nextPageUrl() }}"><i class="fa-solid fa-arrow-right"></i></a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link rounded-circle border-0 shadow-sm text-muted"><i class="fa-solid fa-arrow-right"></i></span></li>
                        @endif

                    </ul>
                </nav>
            </div>

        </div>
    </div>
</section>
@endsection