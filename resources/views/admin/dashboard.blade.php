@extends('admin.layouts.master')
@section('content')
<!-- Greeting -->
<div class="page-heading">
    <h1>Welcome back, {{ Auth::guard('admin')->user()->name }} 👋</h1>
    <p>Here's what's happening today.</p>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    @if(config('app.shop_enabled'))
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-custom">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box bg-blue-100 text-primary-600">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-0">Total Revenue</p>
                    <p class="text-2xl fw-bold mb-0">${{ number_format($total_revenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-custom">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box bg-purple-100 text-purple-600">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-0">Total Orders</p>
                    <p class="text-2xl fw-bold mb-0">{{ number_format($total_orders) }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-custom">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box bg-orange-100 text-orange-600">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-0">Total Customers</p>
                    <p class="text-2xl fw-bold mb-0">{{ number_format($total_customers) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-custom">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box bg-green-100 text-green-600">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-0">Total Subscribers</p>
                    <p class="text-2xl fw-bold mb-0">{{ number_format($total_subscribers) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@if(config('app.shop_enabled'))
<!-- Sales Chart -->
<div class="card-custom-p5 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="section-title mb-0">Daily Sales — {{ now()->format('F Y') }}</h2>
    </div>
    <div class="chart-container">
        <canvas id="salesChart"></canvas>
    </div>
</div>

<!-- Recent Orders -->
<div class="card-custom-static">
    <div class="d-flex align-items-center justify-content-between p-4 pb-0">
        <h2 class="section-title mb-0">Recent Orders</h2>
        <a href="{{ route('admin_order_orders') }}" class="text-sm text-primary-600 hover-underline text-decoration-none">View all</a>
    </div>
    <div class="overflow-x-auto">
        <table class="table-custom mt-3">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_orders as $order)
                <tr>
                    <td class="fw-medium">#{{ $order->order_no }}</td>
                    <td>{{ $order->user?->name ?? 'N/A' }}</td>
                    <td>${{ number_format($order->final_amount, 2) }}</td>
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
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No orders yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
$(function () {
    var days = @json($chart_labels);
    var sales = @json($chart_data);

    if ($('#salesChart').length) {
        new Chart($('#salesChart')[0], {
            type: 'bar',
            data: {
                labels: days,
                datasets: [{
                    label: 'Sales ($)',
                    data: sales,
                    backgroundColor: '#2563eb',
                    hoverBackgroundColor: '#1d4ed8',
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: (t) => 'Day ' + t[0].label,
                            label: (t) => ' $' + t.raw.toLocaleString()
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 11 }, callback: v => '$' + v }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }
});
</script>
@endpush