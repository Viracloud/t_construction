@extends('admin.layouts.master')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="page-heading mb-0">
        <h1>Team Members</h1>
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
                <form action="{{ route('admin_member_store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="label-custom">Select Image *</label>
                        <input type="file" class="form-control-custom" name="image">
                    </div>
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
                        <label class="label-custom">Designation *</label>
                        <input type="text" class="form-control-custom" name="designation">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Short Description *</label>
                        <textarea class="form-control-custom" name="short_description" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Description *</label>
                        <textarea id="editor1" class="form-control-custom" name="description" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Show on Home?</label>
                        <select class="form-control-custom" name="show_on_home">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Phone</label>
                        <input type="text" class="form-control-custom" name="phone">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Email</label>
                        <input type="text" class="form-control-custom" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Experience</label>
                        <input type="text" class="form-control-custom" name="experience">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Facebook</label>
                        <input type="text" class="form-control-custom" name="facebook">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Twitter</label>
                        <input type="text" class="form-control-custom" name="twitter">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">LinkedIn</label>
                        <input type="text" class="form-control-custom" name="linkedin">
                    </div>
                    <div class="mb-3">
                        <label class="label-custom">Instagram</label>
                        <input type="text" class="form-control-custom" name="instagram">
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
                <th>Name</th>
                <th>Show on Home?</th>
                <th>Skill & Award</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <img src="{{ asset('uploads/'.$member->image) }}" alt="" class="w_100">
                </td>
                <td>{{ $member->name }}</td>
                <td>
                    @if($member->show_on_home == 'Yes')
                    <span class="badge bg-success">Yes</span>
                    @else
                    <span class="badge bg-danger">No</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin_member_skills', $member->id) }}" class="btn btn-warning btn-sm">Manage Skill</a>
                    <a href="{{ route('admin_member_awards', $member->id) }}" class="btn btn-info btn-sm">Manage Award</a>
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
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content modal-content-custom">
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title fw-semibold">Edit Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-body-custom">
                            <form action="{{ route('admin_member_update', $member->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="label-custom">Existing Image</label>
                                    <div>
                                        <img src="{{ asset('uploads/'.$member->image) }}" alt="" class="w_150">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Change Image</label>
                                    <input type="file" class="form-control-custom" name="image">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Name *</label>
                                    <input type="text" class="form-control-custom" name="name" value="{{ $member->name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Slug *</label>
                                    <input type="text" class="form-control-custom" name="slug" value="{{ $member->slug }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">SEO Title <small class="text-muted">(optional, up to 60 characters; if empty, the title is used)</small></label>
                                    <input type="text" class="form-control-custom" name="seo_title" maxlength="255" value="{{ $member->seo_title }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">SEO Meta Description <small class="text-muted">(optional, up to 160 characters; if empty, the short description is used)</small></label>
                                    <textarea class="form-control-custom" name="seo_meta_description" rows="3">{{ $member->seo_meta_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Designation *</label>
                                    <input type="text" class="form-control-custom" name="designation" value="{{ $member->designation }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Short Description *</label>
                                    <textarea class="form-control-custom" name="short_description" rows="4">{{ $member->short_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Description *</label>
                                    <textarea id="editor1" class="form-control-custom" name="description" rows="4">{{ $member->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Show on Home?</label>
                                    <select class="form-control-custom" name="show_on_home">
                                        <option value="Yes" {{ $member->show_on_home == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ $member->show_on_home == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Phone</label>
                                    <input type="text" class="form-control-custom" name="phone" value="{{ $member->phone }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Email</label>
                                    <input type="text" class="form-control-custom" name="email" value="{{ $member->email }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Experience</label>
                                    <input type="text" class="form-control-custom" name="experience" value="{{ $member->experience }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Facebook</label>
                                    <input type="text" class="form-control-custom" name="facebook" value="{{ $member->facebook }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Twitter</label>
                                    <input type="text" class="form-control-custom" name="twitter" value="{{ $member->twitter }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">LinkedIn</label>
                                    <input type="text" class="form-control-custom" name="linkedin" value="{{ $member->linkedin }}">
                                </div>
                                <div class="mb-3">
                                    <label class="label-custom">Instagram</label>
                                    <input type="text" class="form-control-custom" name="instagram" value="{{ $member->instagram }}">
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
                            <form action="{{ route('admin_member_delete', $member->id) }}" method="post">
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