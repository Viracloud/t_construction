@extends('front.layouts.master')

{{-- SEO --}}
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->orders_page_title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->orders_page_title }}
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
<style>
    .modal { z-index: 10000 !important; }
    .modal-backdrop { z-index: 9999 !important; }
</style>
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
                        <h3 class="order-title mb-4">Order Information</h3>

                        <div class="table-responsive">
                            <table class="table table-borderless align-middle custom-order-table">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Payment Method</th>
                                        <th>Final Amount</th>
                                        <th>Coupon Code</th>
                                        <th>Shipping Cost</th>
                                        <th>Detail</th>
                                        <th>Status</th>
                                        <th>Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_no }}</td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>${{ $order->final_amount }}</td>
                                        <td>{{ $order->coupon_code }}</td>
                                        <td>${{ $order->shipping_cost }}</td>
                                        <td>
                                            <a href="" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detail_{{ $loop->iteration }}">Detail</a>
                                        </td>
                                        <td>
                                            @if($order->status == 'Completed')
                                            <span class="badge-status completed">Payment Completed</span>
                                            @elseif($order->status == 'Processing')
                                            <span class="badge-status processing">Processing</span>
                                            @elseif($order->status == 'Shipped')
                                            <span class="badge-status shipped">Shipped</span>
                                            @elseif($order->status == 'Cancelled')
                                            <span class="badge-status cancelled">Cancelled</span>
                                            @elseif($order->status == 'Delivered')
                                            <span class="badge-status delivered">Delivered</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('invoice', $order->order_no) }}" class="btn btn-success btn-sm">Invoice</a>
                                        </td>
                                    </tr>
                                    <!-- Detail Modal -->
                                    <div class="modal fade" id="modal_detail_{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <h4>Price Info</h4>
                                                    <div class="row">
                                                        <div class="col-lg-3 mb-3">
                                                            <label for="">Coupon Code</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->coupon_code }}" readonly>
                                                        </div>
                                                        <div class="col-lg-3 mb-3">
                                                            <label for="">Coupon Percentage</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->coupon_percentage }}" readonly>
                                                        </div>
                                                        <div class="col-lg-3 mb-3">
                                                            <label for="">Shipping Cost</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->shipping_cost }}" readonly>
                                                        </div>
                                                        <div class="col-lg-3 mb-3">
                                                            <label for="">Currency</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->currency }}" readonly>
                                                        </div>
                                                    </div>
                                                    <h4>Billing Details</h4>
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="">Billing Name</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->billing_name }}" readonly>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="">Email</label>
                                                            <input type="email" class="form-control" name="" value="{{ $order->billing_email }}" readonly>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="">Billing Phone</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->billing_phone }}" readonly>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="">Billing Address</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->billing_address }}" readonly>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="">Billing Country</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->billing_country }}" readonly>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="">Billing State</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->billing_state }}" readonly>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="">Billing City</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->billing_city }}" readonly>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="">Billing Zip</label>
                                                            <input type="text" class="form-control" name="" value="{{ $order->billing_zip }}" readonly>
                                                        </div>
                                                        <div class="col-lg-12 mb-3">
                                                            <label for="">Billing Note</label>
                                                            <textarea class="form-control" name="" readonly>{{ $order->billing_note }}</textarea>
                                                        </div>
                                                    </div>

                                                    <h4>Product Details</h4>
                                                    @foreach($order->order_details as $detail)
                                                    <div class="mb-3">
                                                        <b>Serial:</b> {{ $loop->iteration }}<br>
                                                        <b>Product Name:</b> {{ $detail->product->name }}<br>
                                                        <b>Product Price:</b> ${{ $detail->product->price }}<br>
                                                        <b>Quantity:</b> {{ $detail->quantity }}
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- // Detail Modal -->
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