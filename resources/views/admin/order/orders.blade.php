@extends('admin.layouts.master')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="page-heading mb-0">
        <h1>Orders</h1>
    </div>
</div>
<div class="card-custom-p5">
    <table id="dataTable" class="table-dt stripe hover">
        <thead>
            <tr>
                <th>Order No</th>
                <th>User</th>
                <th>Payment Method</th>
                <th>Final Amount</th>
                <th>Status</th>
                <th>Invoice</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_no }}</td>
                <td>
                    {{ $order->user->name }}<br>
                    {{ $order->user->email }}<br>
                    {{ $order->user->phone }}
                </td>
                <td>{{ $order->payment_method }}</td>
                <td>${{ $order->final_amount }}</td>
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
                    <a href="{{ route('admin_order_invoice', $order->order_no) }}" class="btn btn-success btn-sm">Invoice</a>
                </td>
                <td>
                    <div class="d-flex align-items-center gap-1">
                        <a class="btn-icon btn-icon btn-edit-row" data-bs-toggle="modal" data-bs-target="#modal_detail_{{ $loop->iteration }}"><i class="fa-solid fa-eye text-xs"></i></a>
                        <a class="btn-icon btn-icon-edit btn-edit-row" data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $loop->iteration }}"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                        <a class="btn-icon btn-icon-delete" data-bs-toggle="modal" data-bs-target="#modal_delete_{{ $loop->iteration }}"><i class="fa-solid fa-trash text-xs"></i></a>
                    </div>
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
            <!-- Edit Modal -->
            <div class="modal fade" id="modal_edit_{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content modal-content-custom">
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title fw-semibold">Edit Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-body-custom">
                            <form action="{{ route('admin_order_change_status', $order->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="label-custom">Select Status *</label>
                                    <select class="form-control-custom" name="status">
                                        <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn-admin-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // Edit Modal -->

            <!-- Delete Modal -->
            <div class="modal fade" id="modal_delete_{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content modal-content-custom">
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title fw-semibold">Delete Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-body-custom">
                            <form action="{{ route('admin_order_delete', $order->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <p>
                                        Are you sure you want to delete this item?
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn-admin-delete">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // Delete Modal -->
            @endforeach
        </tbody>
    </table>
</div>
@endsection