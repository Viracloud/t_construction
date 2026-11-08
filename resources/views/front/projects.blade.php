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
<section class="tmp-project-area py-24">
    <div class="container pt-5">
        @foreach($projects as $project)
        <div class="project-wrapper4 sal-animate" data-sal="slide-up">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 mt-0">
                    <div class="image-section rounded-3 overflow-hidden shadow">
                        <a href="{{ route('project',$project->slug) }}">
                            <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$project->image) }}" class="img-fluid w-100" alt="{{ $project->title }}">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content ps-lg-4">
                        <a href="{{ route('project',$project->slug) }}" class="title">
                            {{ $project->title }}
                        </a>
                        <div class="decription mt-3 mb-3">
                            {!! $project->short_description !!}
                        </div>
                        <a href="{{ route('project',$project->slug) }}" class="primary-btns hover-icon-reverse">
                            <span class="btn-text-content">
                                <span class="btn-icon-wrapper">
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                                    <span class="btn-text">Explore Project</span>
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="row">
            <div class="col-lg-12">
                <nav class="pagination-area mt-5 pt-4">
                    <ul class="pagination justify-content-center gap-2 border-0">
                        
                        {{-- Previous Page Link --}}
                        @if ($projects->onFirstPage())
                            <li class="page-item disabled"><span class="page-link rounded-circle border-0 shadow-sm text-muted"><i class="fa-solid fa-arrow-left"></i></span></li>
                        @else
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $projects->previousPageUrl() }}"><i class="fa-solid fa-arrow-left"></i></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        {{-- Note: This requires the $projects->links() logic or manual loop --}}
                        @foreach ($projects->getUrlRange(max(1, $projects->currentPage() - 2), min($projects->lastPage(), $projects->currentPage() + 2)) as $page => $url)
                            @if ($page == $projects->currentPage())
                                <li class="page-item active"><span class="page-link rounded-circle border-0 shadow-sm">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($projects->hasMorePages())
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $projects->nextPageUrl() }}"><i class="fa-solid fa-arrow-right"></i></a></li>
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