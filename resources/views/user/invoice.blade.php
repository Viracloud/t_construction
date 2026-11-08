@extends('front.layouts.master')

{{-- SEO --}}
@section('robots', 'noindex, follow')

@section('banner')
<section class="tmp-breadcrumb-area bg-image banner-bg" style="background-image: url({{ asset('uploads/'.$global_setting->banner) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content-main text-center">
                    <h1 class="title text-white fw-bold display-4 mb-3">{{ $page_data->invoice_page_title }}: {{ $order->order_no }}</h1>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb justify-content-center align-items-center mb-0">
                            <li class="breadcrumb-item"><i class="fa-solid fa-house text-primary-orange"></i>
                                <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                                {{ $page_data->invoice_page_title }}: {{ $order->order_no }}
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
.w-50 {width: 50%;}
.w-100-p {width: 100% !important;}
.w-30-p {width: 30% !important;}
.w-40-p {width: 40% !important;}
.w-60-p {width: 60% !important;}
.w-70-p {width: 70% !important;}
.w-100 {width: 100px !important;}
.mb_0 {margin-bottom: 0;}
.table-border-0,
.table-border-0 tr,
.table-border-0 tr th,
.table-border-0 tr td {
    border: none!important;
}
.tar {text-align: right;}

.invoice-container {
    border: 1px solid #d5d5d5;
    border-radius: 10px;
    padding: 25px;
}

.invoice-top-right {
    text-align: right;
}
.invoice-top-right h4 {
    font-size: 26px;
    text-transform: uppercase;
}
.invoice-top-right h5 {
    font-size: 16px;
    color: #757575;
}

.invoice-middle {
    margin-top: 40px;
    margin-bottom: 40px;
}
.invoice-middle-left p,
.invoice-middle-right p {
    color: #757575;
    font-size: 16px;
}
.invoice-middle-left h4,
.invoice-middle-right h4 {
    font-size: 20px;
}
.invoice-middle-right {
    text-align: right!important;
}

.invoice-item-table,
.invoice-item-table tr td,
.invoice-item-table tr th {
    border-color: #b9b9b9;
}
.invoice-bottom {
    margin-top: 40px;
}
.invoice-bottom-payment h4 {
    font-size: 18px;
    font-weight: 700;
}
.invoice-bottom-total-box p {
    margin-bottom: 0;
    font-size: 16px;
}
.invoice-bottom-total-box span {
    width: 70px;
    display: inline-block;
}
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
                        <div class="invoice-container" id="print_invoice">
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-border-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="w-50">
                                                            <img src="{{ asset('uploads/logo.png') }}" alt="" style="height: 70px;">
                                                        </td>
                                                        <td class="w-50">
                                                            <div class="invoice-top-right">
                                                                <h4>Invoice</h4>
                                                                <h5>{{ $order->order_no }}</h5>
                                                                <h5>Date: {{ $order->created_at->format('Y-m-d') }}</h5>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-middle">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-border-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="w-50">
                                                            <div class="invoice-middle-left">
                                                                <h4>Invoice To:</h4>
                                                                <p class="mb_0">{{ $order->billing_name }}</p>
                                                                <p class="mb_0">{{ $order->billing_email }}</p>
                                                                <p class="mb_0">{{ $order->billing_phone }}</p>
                                                                <p class="mb_0">{{ $order->billing_address }}</p>
                                                                <p class="mb_0">{{ $order->billing_city }}, {{ $order->billing_state }}, {{ $order->billing_zip }}</p>
                                                            </div>
                                                        </td>
                                                        <td class="w-50">
                                                            <div class="invoice-middle-right">
                                                                <h4>Invoice From:</h4>
                                                                <p class="mb_0">{{ env('APP_NAME') }}</p>
                                                                <p class="mb_0 color_6d6d6d">{{ $admin_data->email }}</p>
                                                                <p class="mb_0">215-899-5780</p>
                                                                <p class="mb_0">3145 Glen Falls Road</p>
                                                                <p class="mb_0">Bensalem, PA 19020</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-item">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered invoice-item-table">
                                                <tbody>
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th class="tar">Subtotal</th>
                                                    </tr>
                                                    @php
                                                    $main_subtotal = 0;
                                                    @endphp
                                                    @foreach($order_details as $item)
                                                    @php
                                                    $product_detail = App\Models\Product::where('id', $item->product_id)->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $product_detail->name }}</td>
                                                        <td>${{ $item->product_price }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        @php
                                                        $subtotal = $item->product_price * $item->quantity;
                                                        @endphp
                                                        <td class="tar">${{ number_format($subtotal, 2) }}</td>
                                                    </tr>
                                                    @php
                                                    $main_subtotal += $subtotal;
                                                    @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td class="tar"><strong>Subtotal:</strong></td>
                                                        <td class="tar">${{ number_format($main_subtotal, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td class="tar"><strong>Shipping Cost:</strong></td>
                                                        <td class="tar">(+) ${{ number_format($order->shipping_cost, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td class="tar"><strong>Coupon Discount:</strong></td>
                                                        @php
                                                        $coupon_discount = $main_subtotal * $order->coupon_percentage / 100;
                                                        @endphp
                                                        <td class="tar">(-) ${{ number_format($coupon_discount, 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-bottom">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-border-0">
                                                <tbody>
                                                    <td class="w-70 invoice-bottom-payment">
                                                        <h4>Payment Method</h4>
                                                        <p>{{ $order->payment_method }}</p>
                                                    </td>
                                                    <td class="w-30 tar invoice-bottom-total-box">
                                                        <h4>Total</h4>
                                                        <p>${{ $order->final_amount }}</p>
                                                    </td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="print-button mt_25">
                            <a onclick="printInvoice()" href="javascript:;" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
                        </div>
                        <script>
                            function printInvoice() {
                                let body = document.body.innerHTML;
                                let data = document.getElementById('print_invoice').innerHTML;
                                document.body.innerHTML = data;
                                window.print();
                                document.body.innerHTML = body;
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection