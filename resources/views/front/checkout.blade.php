@extends('front.layouts.master')

{{-- SEO --}}
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->checkout_page_title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->checkout_page_title }}
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
<form action="{{ route('payment') }}" class="form-content-box" method="post">
@csrf
<section class="tmp-checkout-area tmp-section-gap">
    <div class="container">
        <div class="row g-5">

            <!-- Left Side: Billing  -->
            <div class="col-lg-7">
                <div class="full-grid checkout-padding-shadow p-5 rounded-3">

                    <!-- Billing Details Form -->
                    <div class="billing-fields">
                        <div class="checkout-title mb-4">
                            <h2 class="title h3 fw-bold">Billing & Shipping details</h2>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label description fw-600">Name *</label>
                                    <input name="name" type="text" class="form-control form-control-mod" value="{{ Auth::guard('web')->user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label description fw-600">Email *</label>
                                    <input name="email" type="text" class="form-control form-control-mod" value="{{ Auth::guard('web')->user()->email }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label description fw-600">Phone *</label>
                                    <input name="phone" type="text" class="form-control form-control-mod" value="{{ Auth::guard('web')->user()->phone }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label description fw-600">Address *</label>
                                    <input name="address" type="text" class="form-control form-control-mod" value="{{ Auth::guard('web')->user()->address }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label description fw-600">Country *</label>
                                    <input name="country" type="text" class="form-control form-control-mod" value="{{ Auth::guard('web')->user()->country }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label description fw-600">State *</label>
                                    <input name="state" type="text" class="form-control form-control-mod" value="{{ Auth::guard('web')->user()->state }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label description fw-600">City *</label>
                                    <input name="city" type="text" class="form-control form-control-mod" value="{{ Auth::guard('web')->user()->city }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label description fw-600">Zip *</label>
                                    <input name="zip" type="text" class="form-control form-control-mod" value="{{ Auth::guard('web')->user()->zip }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label description fw-600">Order Note (Optional)</label>
                                    <textarea name="note" class="form-control form-control-mod" rows="4" placeholder="Notes about your order..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Order Summary -->
            <div class="col-lg-5">
                <div class="order-area checkout-padding-shadow p-5 rounded-3 sticky-top sticky-offset-100">
                    <h3 class="title-order h4 fw-bold mb-4">Your Order</h3>

                    <div class="order-wrapper">
                        <!-- Product List Header -->
                        <div class="d-flex justify-content-between pb-3 border-bottom mb-3 fw-bold text-muted">
                            <span>PRODUCTS</span>
                            <span>PRICE</span>
                        </div>

                        @php
                        $main_subtotal = 0;
                        @endphp
                        @foreach($cart as $item)
                        @php
                        $product_detail = \App\Models\Product::where('id',$item['product_id'])->first();
                        @endphp
                        <!-- Product Item 1 -->
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="product-thumb">
                                    <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$product_detail->image) }}" class="rounded" alt="{{ $item['name'] }}">
                                </div>
                                <h4 class="h6 mb-0">{{ $item['name'] }} x {{ $item['quantity'] }}</h4>
                            </div>
                            @php
                            $subtotal = $item['quantity'] * $product_detail->price;
                            @endphp
                            <span class="fw-bold">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        @php
                        $main_subtotal += $subtotal;
                        @endphp
                        @endforeach

                        @php
                        $final_amount = $main_subtotal;
                        @endphp

                        <!-- Totals Table -->
                        <div class="totals-area mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span class="fw-bold">${{ number_format($main_subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Discount</span>
                                @if(session()->has('coupon'))
                                @php
                                $discount_amount = $main_subtotal * (session('coupon')['percentage'] / 100);
                                $final_amount = $final_amount - $discount_amount;
                                @endphp
                                @else
                                @php
                                $discount_amount = 0.00;
                                @endphp
                                @endif
                                <span class="text-muted">(-) <strong class="text-dark">${{ number_format($discount_amount, 2) }}</strong></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                @if(session()->has('shipping_method'))
                                @php
                                $shipping_cost = session('shipping_method')['cost'] ?? 0;
                                $final_amount = $final_amount + $shipping_cost;
                                @endphp
                                @endif
                                <span class="text-muted">(+) <strong class="text-dark">${{ number_format($shipping_cost, 2) }}</strong></span>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                                <span class="h5 fw-bold">Total</span>
                                <span class="h5 fw-bold text-primary">${{ number_format($final_amount, 2) }}</span>
                            </div>
                        </div>

                        <!-- Payment Options -->

                        <h4 style="font-size: 18px;font-weight:700;">Select a Payment Method</h4>

                        <div class="payment-methods bg-light p-4 rounded-3 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay_1" value="PayPal" checked>
                                <label class="form-check-label fw-bold" for="pay_1">Paypal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay_2" value="Stripe">
                                <label class="form-check-label fw-bold" for="pay_2">Stripe</label>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="terms" value="agree" id="terms">
                            <label class="form-check-label small" for="terms"> I have read and agree to the <a href="{{ route('terms') }}" class="text-primary">Terms of Use</a>
                            </label>
                        </div>

                        <button type="submit"
                            class="tmp-btn btn-primary w-100 justify-content-center py-3 hover-icon-reverse">
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">Place Order</span>
                                <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" name="final_amount" value="{{ $final_amount }}">
</form>
@endsection