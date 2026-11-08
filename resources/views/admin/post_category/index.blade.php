@extends('admin.layouts.master')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="page-heading mb-0">
        <h1>Post Categories</h1>
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
                <form action="{{ route('admin_post_category_store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="label-custom">Name *</label>
                        <input type="text" class="form-control-custom" name="name">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Slug *</label>
                        <input type="text" class="form-control-custom" name="slug">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">SEO Title <small class="text-muted">(optional, up to 60 characters; if empty, the title is used)</small></label>
                        <input type="text" class="form-control-custom" name="seo_title" maxlength="255" value="">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">SEO Meta Description <small class="text-muted">(optional, up to 160 characters; if empty, the short description is used)</small></label>
                        <textarea class="form-control-custom" name="seo_meta_description" rows="3"></textarea>
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
                <th>Slug</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($post_categories as $post_category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $post_category->name }}</td>
                <td>{{ $post_category->slug }}</td>
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
                            <form action="{{ route('admin_post_category_update', $post_category->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="label-custom">Name *</label>
                                    <input type="text" class="form-control-custom" name="name" value="{{ $post_category->name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Slug *</label>
                                    <input type="text" class="form-control-custom" name="slug" value="{{ $post_category->slug }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">SEO Title <small class="text-muted">(optional, up to 60 characters; if empty, the title is used)</small></label>
                                    <input type="text" class="form-control-custom" name="seo_title" maxlength="255" value="{{ $post_category->seo_title }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">SEO Meta Description <small class="text-muted">(optional, up to 160 characters; if empty, the short description is used)</small></label>
                                    <textarea class="form-control-custom" name="seo_meta_description" rows="3">{{ $post_category->seo_meta_description }}</textarea>
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
                            <form action="{{ route('admin_post_category_delete', $post_category->id) }}" method="post">
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