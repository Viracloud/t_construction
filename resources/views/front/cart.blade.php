@extends('front.layouts.master')

{{-- SEO --}}
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->cart_page_title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->cart_page_title }}
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
<section class="cart-view-section py-24 pt-5">
    <div class="container py-5">

        <div class="row">
            <div class="col-lg-8">
                <div class="cart-card p-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-start">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>SubTotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $main_subtotal = 0;
                                @endphp
                                @foreach($cart as $item)
                                @php
                                $product_detail = \App\Models\Product::where('id',$item['product_id'])->first();
                                @endphp
                                <form action="{{ route('update_cart') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                <tr class="text-center">
                                    <td class="text-start d-flex align-items-center">
                                        <img loading="lazy" decoding="async" src="{{ asset('uploads/'.$product_detail->image) }}" class="product-img me-3" alt="{{ $item['name'] }}">
                                        <div>
                                            <div class="fw-bold">
                                                <a href="{{ route('product',$product_detail->slug) }}" style="text-decoration:none;color:#333333;">
                                                    {{ $item['name'] }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ $product_detail->price }}</td>
                                    <td class="w-50px">
                                        <div class="d-flex justify-content-center">
                                            <input type="number" class="form-control qty-input" name="quantity" value="{{ $item['quantity'] }}" min="0">
                                        </div>
                                    </td>
                                    @php
                                    $subtotal = $item['quantity'] * $product_detail->price;
                                    @endphp
                                    <td class="fw-bold text-dark">${{ number_format($subtotal, 2) }}</td>
                                    <td>
                                        <button type="submit" style="text-decoration: none; color: inherit;">
                                            <i class="fa-solid fa-edit fs-5"></i>
                                        </button>
                                        <a href="{{ route('remove_from_cart', ['product_id' => $item['product_id']]) }}" onClick="return confirm('Are you sure?')">
                                            <i class="fa-solid fa-circle-xmark remove-item fs-5"></i>
                                        </a>
                                    </td>
                                </tr>
                                </form>
                                @php
                                $main_subtotal += $subtotal;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex coupon-section justify-content-between mt-4">
                        <form action="{{ route('apply_coupon') }}" method="post" class="d-flex gap-2">
                            @csrf
                            <input type="text" class="form-control bg-light-gray" placeholder="Coupon Code" name="code">
                            <button type="submit" class="primary-btns hover-icon-reverse">
                                <span class="btn-text-content">
                                    <span class="btn-icon-wrapper">
                                        <span class="btn-text pe-50">Apply Coupon</span>
                                    </span>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card summary-card p-4">
                    <h5 class="fw-bold mb-4">Cart Totals</h5>

                    @php
                    $final_amount = $main_subtotal;
                    @endphp
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span class="fw-bold">${{ number_format($main_subtotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Discount</span>
                        <span class="fw-bold">
                            @if(session()->has('coupon'))
                            @php
                            $discount_amount = $main_subtotal * (session('coupon')['percentage'] / 100);
                            $final_amount = $final_amount - $discount_amount;
                            @endphp
                            - ${{ number_format($discount_amount, 2) }}
                            @else
                            - $0.00
                            @endif
                        </span>
                    </div>

                    @if(session()->has('coupon'))
                    <div style="color:rgb(37, 145, 68);">
                        Applied Coupon: {{ session('coupon')['code'] }}<br>
                        <a href="{{ route('remove_coupon') }}" style="color:red;">Remove</a>
                    </div>
                    @endif

                    <hr>
                    <form id="shippingForm" action="{{ route('update_shipping') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span style="width:30%;">Shipping</span>
                            <div style="width:70%;">
                                @foreach($shipping_methods as $shipping_method)
                                <div class="form-check">
                                    {{-- Check if this ID matches the ID stored in the session array --}}
                                    <input class="form-check-input shipping-radio" 
                                        type="radio" 
                                        name="shipping_id" 
                                        value="{{ $shipping_method->id }}"
                                        id="ship_{{ $shipping_method->id }}"
                                        {{ (session('shipping_method')['id'] ?? null) == $shipping_method->id ? 'checked' : '' }}>
                                    
                                    <label class="form-check-label" for="ship_{{ $shipping_method->id }}">
                                        <b>{{ $shipping_method->name }} - ${{ number_format($shipping_method->cost, 2) }}</b><br>
                                        <small>({{ $shipping_method->estimated_days }})</small>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    </form>
                    <script>
                        // Pure JavaScript to submit the form on change
                        document.querySelectorAll('.shipping-radio').forEach(radio => {
                            radio.addEventListener('change', function() {
                                this.form.submit();
                            });
                        });
                    </script>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping Cost</span>
                        <span class="fw-bold">
                            @php
                            $shipping_cost = session('shipping_method')['cost'] ?? 0;
                            $final_amount = $final_amount + $shipping_cost;
                            @endphp
                            + ${{ number_format($shipping_cost, 2) }}
                        </span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4 fs-5 fw-bold">
                        <span>Total</span>
                        <span>${{ number_format($final_amount, 2) }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="primary-btns hover-icon-reverse">
                        <span class="btn-text-content">
                            <span class="btn-icon-wrapper d-flex justify-content-center">
                                <span class="btn-text">Proceed To Checkout </span>
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection