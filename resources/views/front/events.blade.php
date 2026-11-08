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
<section class="up-coming-events px-3">
    <div class="container py-24">
        <div class="row g-4">
            @foreach($events as $event)
            <div class="col-md-6 col-lg-4">
                <div class="item h-100">
                    <div class="single-event-card shadow-sm border rounded-4 overflow-hidden bg-white">
                        <div class="thumbnail position-relative overflow-hidden">
                            <a href="{{ route('event', $event->slug) }}">
                                <img loading="lazy" decoding="async" src="{{ asset('uploads/' . $event->image) }}" class="img-fluid w-100" alt="{{ $event->title }}">
                            </a>
                        </div>
                        <div class="content p-4">
                            <div class="d-flex gap-3 mb-3 text-muted small">
                                <span><i class="fa-solid fa-location-dot text-primary me-1"></i> {{ $event->event_location }}</span>
                                <span><i class="fa-solid fa-calendar-day text-primary me-1"></i> {{ $event->event_date }}</span>
                            </div>
                            <a href="{{ route('event', $event->slug) }}" class="text-decoration-none text-dark">
                                <h4 class="title fw-bold mb-4">
                                    {{ $event->title }}
                                </h4>
                            </a>
                            <a href="{{ route('event', $event->slug) }}" class="primary-btns hover-icon-reverse">
                                <span class="btn-text-content">
                                    <span class="btn-icon-wrapper">
                                        <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                                        <span class="btn-text">View Details</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-lg-12">
                <nav class="pagination-area mt-5 pt-4">
                    <ul class="pagination justify-content-center gap-2 border-0">
                        
                        {{-- Previous Page Link --}}
                        @if ($events->onFirstPage())
                            <li class="page-item disabled"><span class="page-link rounded-circle border-0 shadow-sm text-muted"><i class="fa-solid fa-arrow-left"></i></span></li>
                        @else
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $events->previousPageUrl() }}"><i class="fa-solid fa-arrow-left"></i></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        {{-- Note: This requires the $events->links() logic or manual loop --}}
                        @foreach ($events->getUrlRange(max(1, $events->currentPage() - 2), min($events->lastPage(), $events->currentPage() + 2)) as $page => $url)
                            @if ($page == $events->currentPage())
                                <li class="page-item active"><span class="page-link rounded-circle border-0 shadow-sm">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($events->hasMorePages())
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $events->nextPageUrl() }}"><i class="fa-solid fa-arrow-right"></i></a></li>
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