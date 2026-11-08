@extends('admin.layouts.master')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="page-heading mb-0">
        <h1>Posts</h1>
    </div>
    <a href="" class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#modal_add">
        <i class="fa-solid fa-plus me-1"></i>Add Item
    </a>
</div>

<!-- Add Modal -->
<div class="modal fade" id="modal_add" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title fw-semibold">Add Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-custom">
                <form action="{{ route('admin_post_store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="label-custom">Select Image *</label>
                        <input type="file" class="form-control-custom" name="image">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Post Category *</label>
                        <select name="post_category_id" class="form-control-custom">
                            <option value="">Select Category</option>
                            @foreach($post_categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Title *</label>
                        <input type="text" class="form-control-custom" name="title">
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
                        <label class="label-custom">Description *</label>
                        <textarea id="editor1" class="form-control-custom" name="description" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Tags (Comma Separated)</label>
                        <input type="text" class="form-control-custom" name="tags">
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
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <img src="{{ asset('uploads/'.$post->image) }}" alt="" class="w_200">
                </td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->post_category->name }}</td>
                <td>
                    <div class="d-flex align-items-center gap-1">
                        <a class="btn-icon btn-icon-edit btn-edit-row" data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $loop->iteration }}"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                        <a class="btn-icon btn-icon-delete" data-bs-toggle="modal" data-bs-target="#modal_delete_{{ $loop->iteration }}"><i class="fa-solid fa-trash text-xs"></i></a>
                    </div>
                </td>
            </tr>
            <!-- Edit Modal -->
            <div class="modal fade" id="modal_edit_{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content modal-content-custom">
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title fw-semibold">Edit Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-body-custom">
                            <form action="{{ route('admin_post_update', $post->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="label-custom">Existing Image</label>
                                    <div>
                                        <img src="{{ asset('uploads/'.$post->image) }}" alt="" class="w_150">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Change Image</label>
                                    <input type="file" class="form-control-custom" name="image">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Post Category *</label>
                                    <select name="post_category_id" class="form-control-custom">
                                        <option value="">Select Category</option>
                                        @foreach($post_categories as $item)
                                        <option value="{{ $item->id }}" {{ $post->post_category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Title *</label>
                                    <input type="text" class="form-control-custom" name="title" value="{{ $post->title }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Slug *</label>
                                    <input type="text" class="form-control-custom" name="slug" value="{{ $post->slug }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">SEO Title <small class="text-muted">(optional, up to 60 characters; if empty, the title is used)</small></label>
                                    <input type="text" class="form-control-custom" name="seo_title" maxlength="255" value="{{ $post->seo_title }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">SEO Meta Description <small class="text-muted">(optional, up to 160 characters; if empty, the short description is used)</small></label>
                                    <textarea class="form-control-custom" name="seo_meta_description" rows="3">{{ $post->seo_meta_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Description *</label>
                                    <textarea id="editor2" class="form-control-custom" name="description" rows="4">{{ $post->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Tags (Comma Separated)</label>
                                    <input type="text" class="form-control-custom" name="tags" value="{{ $post->tags }}">
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
                            <form action="{{ route('admin_post_delete', $post->id) }}" method="post">
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