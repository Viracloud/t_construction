@extends('admin.layouts.master')
@section('content')
<div class="page-heading">
    <h1>Page Home Item</h1>
</div>

<form action="{{ route('admin_page_home_update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-12 col-xl-12">

            <h6 class="cus-heading">About Section</h6>
            <div class="card-custom-p mb-4">
                <div class="mb-3">
                    <label class="label-custom">Status *</label>
                    <select name="about_status" class="form-control-custom">
                        <option value="Show" {{ $page_data->about_status == 'Show' ? 'selected' : '' }}>Show</option>
                        <option value="Hide" {{ $page_data->about_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <h6 class="cus-heading">Service Section</h6>
                    <div class="card-custom-p mb-4">
                        <div class="mb-3">
                            <label class="label-custom">Subheading</label>
                            <input type="text" name="service_subheading" value="{{ $page_data->service_subheading }}" class="form-control-custom">
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Heading</label>
                            <textarea name="service_heading" class="form-control-custom">{{ $page_data->service_heading }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Text</label>
                            <textarea name="service_text" class="form-control-custom">{{ $page_data->service_text }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Status *</label>
                            <select name="service_status" class="form-control-custom">
                                <option value="Show" {{ $page_data->service_status == 'Show' ? 'selected' : '' }}>Show</option>
                                <option value="Hide" {{ $page_data->service_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h6 class="cus-heading">Project Section</h6>
                    <div class="card-custom-p mb-4">
                        <div class="mb-3">
                            <label class="label-custom">Subheading</label>
                            <input type="text" name="project_subheading" value="{{ $page_data->project_subheading }}" class="form-control-custom">
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Heading</label>
                            <textarea name="project_heading" class="form-control-custom">{{ $page_data->project_heading }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Text</label>
                            <textarea name="project_text" class="form-control-custom">{{ $page_data->project_text }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Status *</label>
                            <select name="project_status" class="form-control-custom">
                                <option value="Show" {{ $page_data->project_status == 'Show' ? 'selected' : '' }}>Show</option>
                                <option value="Hide" {{ $page_data->project_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            


            <div class="row">
                <div class="col-lg-6">
                    <h6 class="cus-heading">Testimonial Section</h6>
                    <div class="card-custom-p mb-4">
                        <div class="mb-3">
                            <label class="label-custom">Subheading</label>
                            <input type="text" name="testimonial_subheading" value="{{ $page_data->testimonial_subheading }}" class="form-control-custom">
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Heading</label>
                            <textarea name="testimonial_heading" class="form-control-custom">{{ $page_data->testimonial_heading }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Status *</label>
                            <select name="testimonial_status" class="form-control-custom">
                                <option value="Show" {{ $page_data->testimonial_status == 'Show' ? 'selected' : '' }}>Show</option>
                                <option value="Hide" {{ $page_data->testimonial_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h6 class="cus-heading">Team Section</h6>
                    <div class="card-custom-p mb-4">
                        <div class="mb-3">
                            <label class="label-custom">Subheading</label>
                            <input type="text" name="team_subheading" value="{{ $page_data->team_subheading }}" class="form-control-custom">
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Heading</label>
                            <textarea name="team_heading" class="form-control-custom">{{ $page_data->team_heading }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Status *</label>
                            <select name="team_status" class="form-control-custom">
                                <option value="Show" {{ $page_data->team_status == 'Show' ? 'selected' : '' }}>Show</option>
                                <option value="Hide" {{ $page_data->team_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-lg-6">
                    <h6 class="cus-heading">Event Section</h6>
                    <div class="card-custom-p mb-4">
                        <div class="mb-3">
                            <label class="label-custom">Subheading</label>
                            <input type="text" name="event_subheading" value="{{ $page_data->event_subheading }}" class="form-control-custom">
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Heading</label>
                            <textarea name="event_heading" class="form-control-custom">{{ $page_data->event_heading }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Status *</label>
                            <select name="event_status" class="form-control-custom">
                                <option value="Show" {{ $page_data->event_status == 'Show' ? 'selected' : '' }}>Show</option>
                                <option value="Hide" {{ $page_data->event_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h6 class="cus-heading">Blog Section</h6>
                    <div class="card-custom-p mb-4">
                        <div class="mb-3">
                            <label class="label-custom">Subheading</label>
                            <input type="text" name="blog_subheading" value="{{ $page_data->blog_subheading }}" class="form-control-custom">
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Heading</label>
                            <textarea name="blog_heading" class="form-control-custom">{{ $page_data->blog_heading }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="label-custom">Status *</label>
                            <select name="blog_status" class="form-control-custom">
                                <option value="Show" {{ $page_data->blog_status == 'Show' ? 'selected' : '' }}>Show</option>
                                <option value="Hide" {{ $page_data->blog_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            

            <h6 class="cus-heading">SEO Section</h6>
            <div class="card-custom-p mb-4">
                <div class="mb-3">
                    <label class="label-custom">Title</label>
                    <input type="text" name="seo_title" value="{{ $page_data->seo_title }}" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="label-custom">Meta Description</label>
                    <textarea name="seo_meta_description" class="form-control-custom">{{ $page_data->seo_meta_description }}</textarea>
                </div>
            </div>
            
            <div class="card-custom-p mb-4">
                <div>
                    <button type="submit" class="btn-admin-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection