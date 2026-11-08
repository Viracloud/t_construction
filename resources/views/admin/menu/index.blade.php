@extends('admin.layouts.master')
@section('content')
<div class="page-heading">
    <h1>Menu</h1>
</div>

<form action="{{ route('admin_menu_update') }}" method="post">
    @csrf
    <div class="row g-4">
        <div class="col-12 col-xl-12">
            <div class="card-custom-p">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Home - Name</label>
                        <input type="text" name="menu_home_name" value="{{ $menu->menu_home_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Home - Status</label>
                        <select name="menu_home_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_home_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_home_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">About - Name</label>
                        <input type="text" name="menu_about_name" value="{{ $menu->menu_about_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">About - Status</label>
                        <select name="menu_about_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_about_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_about_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Service - Name</label>
                        <input type="text" name="menu_service_name" value="{{ $menu->menu_service_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Service - Status</label>
                        <select name="menu_service_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_service_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_service_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Event - Name</label>
                        <input type="text" name="menu_event_name" value="{{ $menu->menu_event_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Event - Status</label>
                        <select name="menu_event_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_event_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_event_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Team Member - Name</label>
                        <input type="text" name="menu_team_member_name" value="{{ $menu->menu_team_member_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Team Member - Status</label>
                        <select name="menu_team_member_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_team_member_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_team_member_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Project - Name</label>
                        <input type="text" name="menu_project_name" value="{{ $menu->menu_project_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Project - Status</label>
                        <select name="menu_project_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_project_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_project_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3" @if(!config('app.shop_enabled')) style="display:none" @endif>
                        <label class="label-custom">Shop - Name</label>
                        <input type="text" name="menu_shop_name" value="{{ $menu->menu_shop_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3" @if(!config('app.shop_enabled')) style="display:none" @endif>
                        <label class="label-custom">Shop - Status</label>
                        <select name="menu_shop_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_shop_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_shop_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Gallery - Name</label>
                        <input type="text" name="menu_gallery_name" value="{{ $menu->menu_gallery_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Gallery - Status</label>
                        <select name="menu_gallery_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_gallery_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_gallery_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">FAQ - Name</label>
                        <input type="text" name="menu_faq_name" value="{{ $menu->menu_faq_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">FAQ - Status</label>
                        <select name="menu_faq_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_faq_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_faq_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Blog - Name</label>
                        <input type="text" name="menu_blog_name" value="{{ $menu->menu_blog_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Blog - Status</label>
                        <select name="menu_blog_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_blog_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_blog_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Contact - Name</label>
                        <input type="text" name="menu_contact_name" value="{{ $menu->menu_contact_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Contact - Status</label>
                        <select name="menu_contact_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_contact_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_contact_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Login - Name</label>
                        <input type="text" name="menu_login_name" value="{{ $menu->menu_login_name }}" class="form-control-custom">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="label-custom">Login - Status</label>
                        <select name="menu_login_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_login_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_login_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3" @if(!config('app.shop_enabled')) style="display:none" @endif>
                        <label class="label-custom">Cart - Status</label>
                        <select name="menu_cart_status" class="form-control-custom">
                            <option value="Show" {{ $menu->menu_cart_status == 'Show' ? 'selected' : '' }}>Show</option>
                            <option value="Hide" {{ $menu->menu_cart_status == 'Hide' ? 'selected' : '' }}>Hide</option>
                        </select>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn-admin-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection