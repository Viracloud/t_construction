@extends('admin.layouts.master')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="page-heading mb-0">
        <h1>Shipping Methods</h1>
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
                <form action="{{ route('admin_shipping_store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="label-custom">Name *</label>
                        <input type="text" class="form-control-custom" name="name">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Cost *</label>
                        <input type="text" class="form-control-custom" name="cost">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Estimated Days *</label>
                        <input type="text" class="form-control-custom" name="estimated_days">
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
                <th>Name</th>
                <th>Cost</th>
                <th>Estimated Days</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shipping_methods as $shipping_method)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $shipping_method->name }}</td>
                <td>{{ $shipping_method->cost }}</td>
                <td>{{ $shipping_method->estimated_days }}</td>
                <td>
                    @if($shipping_method->status == 'Active')
                    <span class="badge bg-success">{{ $shipping_method->status }}</span>
                    @else
                    <span class="badge bg-danger">{{ $shipping_method->status }}</span>
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
                            <form action="{{ route('admin_shipping_update', $shipping_method->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="label-custom">Name *</label>
                                    <input type="text" class="form-control-custom" name="name" value="{{ $shipping_method->name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Cost *</label>
                                    <input type="text" class="form-control-custom" name="cost" value="{{ $shipping_method->cost }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Estimated Days *</label>
                                    <input type="text" class="form-control-custom" name="estimated_days" value="{{ $shipping_method->estimated_days }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Status *</label>
                                    <select class="form-control-custom" name="status">
                                        <option value="Active" {{ $shipping_method->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $shipping_method->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
                            <form action="{{ route('admin_shipping_delete', $shipping_method->id) }}" method="post">
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