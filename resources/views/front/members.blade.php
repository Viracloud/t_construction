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
<section class="team-area px-3">
    <div class="container py-24">
        <div class="row g-4">
            
            @foreach($members as $member)
            <div class="col-lg-3 col-md-6">
                <div class="team-card-v2">
                    <div class="image-section">
                        <a href="{{ route('member', $member->slug) }}">
                            <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$member->image) }}" class="img-fluid w-100"
                                alt="{{ $member->name }}">
                        </a>
                        <div class="social-wrapper">
                            <ul class="list-unstyled mb-0 d-flex justify-content-center gap-2">
                                @if($member->facebook != '')
                                <li>
                                    <a href="{{ $member->facebook }}"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                @endif
                                @if($member->twitter != '')
                                <li>
                                    <a href="{{ $member->twitter }}"><i class="fa-brands fa-twitter"></i></a>
                                </li>
                                @endif
                                @if($member->linkedin != '')
                                <li>
                                    <a href="{{ $member->linkedin }}"><i class="fa-brands fa-linkedin-in"></i></a>
                                </li>
                                @endif
                                @if($member->instagram != '')
                                <li>
                                    <a href="{{ $member->instagram }}"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="content-area position-relative content-area-padding">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="title mb-2">
                                    <a href="{{ route('member', $member->slug) }}" class="title text-reset text-decoration-none fw-bold">{{ $member->name }}</a>
                                </h5>
                                <p class="designation text-muted mb-1">{{ $member->designation }}</p>
                            </div>
                            <a href="{{ route('member', $member->slug) }}" class="team-arrow-icon text-decoration-none text-reset">
                                <div class="arrow-circle">
                                    <span class="arrow-icon">↗</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>

        <div class="row">
            <div class="col-lg-12">
                <nav class="pagination-area mt-5 pt-4">
                    <ul class="pagination justify-content-center gap-2 border-0">
                        
                        {{-- Previous Page Link --}}
                        @if ($members->onFirstPage())
                            <li class="page-item disabled"><span class="page-link rounded-circle border-0 shadow-sm text-muted"><i class="fa-solid fa-arrow-left"></i></span></li>
                        @else
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $members->previousPageUrl() }}"><i class="fa-solid fa-arrow-left"></i></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        {{-- Note: This requires the $members->links() logic or manual loop --}}
                        @foreach ($members->getUrlRange(max(1, $members->currentPage() - 2), min($members->lastPage(), $members->currentPage() + 2)) as $page => $url)
                            @if ($page == $members->currentPage())
                                <li class="page-item active"><span class="page-link rounded-circle border-0 shadow-sm">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($members->hasMorePages())
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $members->nextPageUrl() }}"><i class="fa-solid fa-arrow-right"></i></a></li>
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