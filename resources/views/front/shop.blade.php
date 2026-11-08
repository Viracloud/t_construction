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
<section class="tmp-shop-area tmp-section-gap">
    <div class="container">
        
        <div class="row g-5 align-items-center">
            <div class="col-xl-5">
                <div class="filter-shorting-list-wrapper">
                    <div class="tmp-search-filter">
                        <form action="{{ route('shop') }}" class="tmp-search" method="get">
                            <input type="text" name="search" value="{{ request()->get('search') }}" placeholder="Search Your Product ..." autocomplete="off">
                            <button type="submit" class="tmp-btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5 pt--50">
            @forelse($products as $product)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="tmp-shop-card-1">
                    <div class="inner">
                        <div class="content text-center pt-0 pb-1">
                            <h3 class="title"><a href="{{ route('product',$product->slug) }}">{{ $product->name }}</a></h3>
                        </div>
                        <div class="thumbnail">
                            <a href="{{ route('product',$product->slug) }}">
                                <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$product->image) }}" alt="Product" class="w-100 h-350px">
                            </a>
                            <div class="action-buttons">
                                <form action="{{ route('add_to_wishlist') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="action" data-tooltip="Wishlist">
                                        <button type="submit" class="text-reset"><i class="fa-regular fa-heart"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="content mt-3 text-center">
                            <div class="shop-review d-flex justify-content-center align-items-center gap-3">
                                @php
                                $review_count = App\Models\Review::where('product_id', $product->id)->count();
                                $average_rating = App\Models\Review::where('product_id', $product->id)->avg('rating');
                                @endphp
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $average_rating)
                                            <i class="fas fa-star"></i>
                                        @elseif ($i - 0.5 <= $average_rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-count">({{ $review_count }})</span>
                            </div>
                            <div class="shop-price my-2 mb-3">
                                <span class="current-price theme-gradient">${{ $product->price }}</span>
                                @if($product->old_price)
                                <span class="off-price text-decoration-line-through ms-2">${{ $product->old_price }}</span>
                                @endif
                            </div>
                            @if($product->stock > 0)
                            <div class="addto-cart-btn mt--20">
                                <form action="{{ route('add_to_cart') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="primary-btns hover-icon-reverse">
                                    <span class="btn-text-content">
                                        <span class="btn-icon-wrapper">
                                            <span class="btn-icon">
                                                <i class="fa-solid fa-bag-shopping"></i>
                                            </span>
                                            <span class="btn-text">Add to Cart</span>
                                        </span>
                                    </span>
                                </button>
                                </form>
                            </div>
                            @else
                            <div class="addto-cart-btn mt--20">
                                <a href="javascript:void;" class="primary-btns hover-icon-reverse" style="background:rgb(237, 188, 188)!important;">
                                    <span class="btn-text-content">
                                        <span class="btn-icon-wrapper">
                                            <span class="btn-icon">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                            <span class="btn-text">Out Of Stock</span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-lg-12">
                <div class="alert alert-danger text-center" role="alert">
                    No products found.
                </div>
            </div>
            @endforelse

            @if($products->hasPages())
            <div class="col-lg-12">
                <nav class="pagination-area mt-5 pt-4">
                    <ul class="pagination justify-content-center gap-2 border-0">
                        
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <li class="page-item disabled"><span class="page-link rounded-circle border-0 shadow-sm text-muted"><i class="fa-solid fa-arrow-left"></i></span></li>
                        @else
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $products->previousPageUrl() }}"><i class="fa-solid fa-arrow-left"></i></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        {{-- Note: This requires the $products->links() logic or manual loop --}}
                        @foreach ($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                            @if ($page == $products->currentPage())
                                <li class="page-item active"><span class="page-link rounded-circle border-0 shadow-sm">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($products->hasMorePages())
                            <li class="page-item"><a class="page-link rounded-circle border-0 shadow-sm text-dark" href="{{ $products->nextPageUrl() }}"><i class="fa-solid fa-arrow-right"></i></a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link rounded-circle border-0 shadow-sm text-muted"><i class="fa-solid fa-arrow-right"></i></span></li>
                        @endif

                    </ul>
                </nav>
            </div>
            @endif

        </div>
    </div>
</section>
@endsection