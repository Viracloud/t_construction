@extends('front.layouts.master')

{{-- SEO --}}
@section('seo_title', 'Archive: '.$month.' | '.$global_setting->site_name)
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">Archive: {{ $month }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                Archive: {{ $month }}
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
<section class= "blogs-section px-3 py-5">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <section class="tmp-blog-area2 inner py-5">
                    <div class="container">
                        <div class="row g-4">
                            @forelse($posts as $post)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card h-100 border-0 shadow-sm blog-card-style-two rounded-3 overflow-hidden">
                                    <div class="image-section position-relative">
                                        <a href="{{ route('post',$post->slug) }}">
                                            <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$post->image) }}"  class="card-img-top img-fluid" alt="{{ $post->title }}">
                                        </a>
                                    </div>
                                    <div class="card-body p-4">
                                        <h4 class="card-title fw-bold mb-4">
                                            <a href="{{ route('post',$post->slug) }}" class="text-decoration-none text-dark hover-primary">
                                                {{ $post->title }}
                                            </a>
                                        </h4>
                                        <div class="button-area mt-auto">
                                            <a href="{{ route('post',$post->slug) }}" class="btn btn-link p-0 text-decoration-none fw-bold text-primary"> READ MORE <i class="fa-solid fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="alert alert-danger text-center mb-0">
                                    No posts found
                                </div>
                            </div>
                            @endforelse
                        </div>


                        @if($posts->hasPages())
                        <div class="row">
                            <div class="col-lg-12">
                                <nav class="pagination-area mt-5 pt-4">
                                    <ul class="pagination justify-content-center gap-2 border-0">
                                        
                                        {{-- Previous Page Link --}}
                                        @if ($posts->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link rounded-circle border-0 shadow-sm text-muted"><i class="fa-solid fa-arrow-left"></i></span></li>
                                        @else
                                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $posts->previousPageUrl() }}"><i class="fa-solid fa-arrow-left"></i></a></li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        {{-- Note: This requires the $posts->links() logic or manual loop --}}
                                        @foreach ($posts->getUrlRange(max(1, $posts->currentPage() - 2), min($posts->lastPage(), $posts->currentPage() + 2)) as $page => $url)
                                            @if ($page == $posts->currentPage())
                                                <li class="page-item active"><span class="page-link rounded-circle border-0 shadow-sm">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($posts->hasMorePages())
                                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $posts->nextPageUrl() }}"><i class="fa-solid fa-arrow-right"></i></a></li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link rounded-circle border-0 shadow-sm text-muted"><i class="fa-solid fa-arrow-right"></i></span></li>
                                        @endif

                                    </ul>
                                </nav>
                            </div>
                        </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection