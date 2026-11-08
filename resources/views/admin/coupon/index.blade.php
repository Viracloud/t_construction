@extends('admin.layouts.master')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="page-heading mb-0">
        <h1>Coupons</h1>
    </div>
    <a href="" class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#modal_add">
        <i class="fa-solid fa-plus me-1"></i>Add Item
    </a>
</div>

<!-- Add Modal -->
<div class="modal fade" id="modal_add" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title fw-semibold">Add Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-custom">
                <form action="{{ route('admin_coupon_store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="label-custom">Code *</label>
                        <input type="text" class="form-control-custom" name="code">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Percentage *</label>
                        <input type="text" class="form-control-custom" name="percentage">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Usage Limit *</label>
                        <input type="text" class="form-control-custom" name="usage_limit">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Start Date *</label>
                        <input id="datepicker" type="text" class="form-control-custom" name="start_date">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Expire Date *</label>
                        <input id="datepicker1" type="text" class="form-control-custom" name="expire_date">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Status *</label>
                        <select class="form-control-custom" name="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn-admin-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- // Add Modal -->


<div class="card-custom-p5">
    <table id="dataTable" class="table-dt stripe hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Percentage</th>
                <th>Usage Limit</th>
                <th>Start Date</th>
                <th>Expire Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $coupon->code }}</td>
                <td>{{ $coupon->percentage }}</td>
                <td>{{ $coupon->usage_limit }}</td>
                <td>{{ $coupon->start_date }}</td>
                <td>{{ $coupon->expire_date }}</td>
                <td>
                    @if($coupon->status == 'Active')
                    <span class="badge bg-success">{{ $coupon->status }}</span>
                    @else
                    <span class="badge bg-danger">{{ $coupon->status }}</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center gap-1">
                        <a class="btn-icon btn-icon-edit btn-edit-row" data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $loop->iteration }}"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                        <a class="btn-icon btn-icon-delete" data-bs-toggle="modal" data-bs-target="#modal_delete_{{ $loop->iteration }}"><i class="fa-solid fa-trash text-xs"></i></a>
                    </div>
                </td>
            </tr>
            <!-- Edit Modal -->
            <div class="modal fade" id="modal_edit_{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content modal-content-custom">
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title fw-semibold">Edit Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-body-custom">
                            <form action="{{ route('admin_coupon_update', $coupon->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="label-custom">Code *</label>
                                    <input type="text" class="form-control-custom" name="code" value="{{ $coupon->code }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Percentage *</label>
                                    <input type="text" class="form-control-custom" name="percentage" value="{{ $coupon->percentage }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Usage Limit *</label>
                                    <input type="text" class="form-control-custom" name="usage_limit" value="{{ $coupon->usage_limit }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Start Date *</label>
                                    <input id="datepicker2" type="text" class="form-control-custom" name="start_date" value="{{ $coupon->start_date }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Expire Date *</label>
                                    <input id="datepicker3" type="text" class="form-control-custom" name="expire_date" value="{{ $coupon->expire_date }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Status *</label>
                                    <select class="form-control-custom" name="status">
                                        <option value="Active" {{ $coupon->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $coupon->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
                            <form action="{{ route('admin_coupon_delete', $coupon->id) }}" method="post">
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