@extends('front.layouts.master')

{{-- SEO --}}
@section('seo_title', \App\Support\Seo::title($product->seo_title, $product->name, $global_setting->site_name))
@section('seo_description', \App\Support\Seo::description($product->seo_meta_description, $product->short_description, $product->description))
@section('og_image', asset('uploads/'.$product->image))

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $product->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('shop') }}" class="text-white text-decoration-none opacity-75">{{ $page_data->page_title }}</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $product->name }}
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
<section class="product-detail-section tmp-section-gap">
    <div class="container">
        <div class="row g-5">

            <!-- Left: Product Gallery -->
            <div class="col-lg-6">
                <div class="product-gallery">
                    <div class="main-image-wrapper rounded-3 overflow-hidden mb-3 border">
                        <img loading="lazy" decoding="async" src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->name }}" class="product-main-image w-100" id="mainProductImage">
                    </div>
                    <div class="thumbnail-list d-flex gap-2">
                        <div class="product-thumb active rounded-2 overflow-hidden border" data-image="{{ asset('uploads/' . $product->image) }}">
                            <img loading="lazy" decoding="async" src="{{ asset('uploads/' . $product->image) }}" alt="Thumb 1" class="w-100 h-100 object-fit-cover">
                        </div>
                        @foreach($product->photos as $photo)
                        <div class="product-thumb rounded-2 overflow-hidden border" data-image="{{ asset('uploads/' . $photo->photo) }}">
                            <img loading="lazy" decoding="async" src="{{ asset('uploads/' . $photo->photo) }}" alt="Thumb {{ $loop->iteration }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <h2 class="product-title fw-bold mb-2">
                        {{ $product->name }}
                    </h2>
                    @php
                    $review_count = App\Models\Review::where('product_id', $product->id)->count();
                    @endphp
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rating text-warning">
                            @php
                            $average_rating = App\Models\Review::where('product_id', $product->id)->avg('rating');
                            @endphp
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
                        <span class="text-muted">({{ $review_count }} Reviews)</span>
                        @if($product->stock > 0)
                        <span class="badge bg-success-subtle text-success">In Stock</span>
                        @else
                        <span class="badge bg-danger-subtle text-danger">Out of Stock</span>
                        @endif
                    </div>

                    <div class="product-price mb-4">
                        <span class="h3 fw-bold theme-gradient">${{ $product->price }}</span>
                        @if($product->old_price)
                        <span class="text-decoration-line-through text-muted ms-2 fs-5">${{ $product->old_price }}</span>
                        @php
                        // calculate how many percentage is off
                        $discount = $product->old_price - $product->price;
                        $percentage = round(($discount / $product->old_price) * 100);
                        @endphp
                        <span class="badge bg-danger ms-2">{{ $percentage }}% OFF</span>
                        @endif
                    </div>

                    <p class="text-muted mb-4">
                        {!! nl2br($product->short_description) !!}
                    </p>

                    <hr>

                    @if($product->stock > 0)
                    <form action="{{ route('add_to_cart') }}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        <div class="qty-wrapper d-flex align-items-center border rounded-pill overflow-hidden">
                            <button type="button" class="btn btn-light border-0 px-3 py-2 qty-btn" id="qtyMinus">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" class="form-control border-0 text-center qty-input" value="1" min="1" max="99" id="qtyInput" readonly>
                            <button type="button" class="btn btn-light border-0 px-3 py-2 qty-btn" id="qtyPlus">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <button type="submit" class="primary-btns hover-icon-reverse">
                            <span class="btn-text-content">
                                <span class="btn-icon-wrapper">
                                    <span class="btn-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                                    <span class="btn-text">Add to Cart</span>
                                </span>
                            </span>
                        </button>
                    </div>
                    </form>
                    @else
                    <div class="col-lg-12">
                        <div class="alert alert-danger text-center" role="alert">
                            Product is Out of Stock
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ========= Product Detail Section End ======== -->

<!-- ========= Product Tabs Section Start ======== -->
<section class="product-tabs-section pb-5">
    <div class="container">
        <ul class="nav nav-tabs product-nav-tabs border-0 mb-4 gap-2 flex-wrap" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active product-tab-btn" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link product-tab-btn" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">Specifications</button>
            </li>
            @php
            $review_count = App\Models\Review::where('product_id', $product->id)->count();
            @endphp
            <li class="nav-item" role="presentation">
                <button class="nav-link product-tab-btn" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews ({{ $review_count }})</button>
            </li>
        </ul>

        <div class="tab-content product-tab-content border rounded-3 p-4 p-md-5" id="productTabContent">

            <!-- Description Tab -->
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <p>
                    {!! $product->description !!}
                </p>

            </div>

            <!-- Specifications Tab -->
            <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <tbody>
                            @foreach($product->specifications as $spec)
                            <tr>
                                <th class="bg-light" width="35%">{{ $spec->name }}</th>
                                <td>{{ $spec->value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <h4 class="fw-bold mb-4">Customer Reviews</h4>

                
                @php
                $reviews = App\Models\Review::where('product_id', $product->id)->get();
                @endphp
                @forelse($reviews as $review)
                <div class="review-item d-flex gap-3 pb-4 mb-4 border-bottom">
                    @php
                    $email = trim(strtolower($review->user->email));
                    $hash = md5($email);
                    $gravatar_url = "https://www.gravatar.com/avatar/$hash?s=80&d=mp";
                    @endphp
                    <img loading="lazy" decoding="async" src="{{ $gravatar_url }}" alt="{{ $review->user->name }}" class="rounded-circle object-fit-cover" width="56" height="56">

                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="fw-bold mb-0">{{ $review->user->name }}</h6>
                            <span class="text-muted small">— {{ $review->created_at->format('F d, Y') }}</span>
                        </div>
                        <div class="rating text-warning mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-muted mb-0">
                            {!! nl2br($review->comment) !!}
                        </p>
                    </div>
                </div>
                @empty
                <div class="alert alert-danger text-center" role="alert">
                    No reviews yet. Be the first to review this product!
                </div>
                @endforelse
                

                <!-- Write a Review -->
                <div class="write-review mt-5">
                    <h5 class="fw-bold mb-3">Write a Review</h5>

                    @if(!Auth::guard('web')->check())
                    <div class="alert alert-danger text-center" role="alert">
                        Please <a href="{{ route('login') }}" class="alert-link">login</a> to write a review.
                    </div>
                    @endif

                    @if(Auth::guard('web')->check())
                    <form action="{{ route('submit_review') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Your Rating</label>
                                <input type="hidden" name="rating" id="rating-input" value="0">
                                <div class="review-stars d-flex gap-1">
                                    <i class="fa-regular fa-star review-star" data-rating="1"></i>
                                    <i class="fa-regular fa-star review-star" data-rating="2"></i>
                                    <i class="fa-regular fa-star review-star" data-rating="3"></i>
                                    <i class="fa-regular fa-star review-star" data-rating="4"></i>
                                    <i class="fa-regular fa-star review-star" data-rating="5"></i>
                                </div>
                                <script>
                                    // 1. Select all the star icons
                                    const stars = document.querySelectorAll('.review-star');
                                    const ratingInput = document.getElementById('rating-input');

                                    // 2. Add a click event to each star
                                    stars.forEach(star => {
                                        star.addEventListener('click', function() {
                                            // 'this' now correctly refers to the star that was clicked
                                            const selectedRating = this.getAttribute('data-rating');
                                            
                                            // 3. Update the hidden input value
                                            ratingInput.value = selectedRating;

                                            // Optional: Add visual feedback so the user knows it's selected
                                            console.log("Rating set to: " + ratingInput.value);
                                        });
                                    });
                                </script>
                            </div>
                            <div class="col-12">
                                <textarea name="comment" class="form-control py-3" rows="5" placeholder="Write your review..." required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="primary-btns hover-icon-reverse">
                                    <span class="btn-text-content">
                                        <span class="btn-icon-wrapper">
                                            <span class="btn-icon"><i class="fa-solid fa-paper-plane"></i></span>
                                            <span class="btn-text">Submit Review</span>
                                        </span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
