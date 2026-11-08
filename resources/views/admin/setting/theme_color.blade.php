@extends('admin.layouts.master')
@section('content')
<div class="page-heading">
    <h1>Settings - Theme Color</h1>
</div>

<form action="{{ route('admin_setting_theme_color_update') }}" method="post">
    @csrf
    <div class="row g-4">
        <div class="col-12 col-xl-12">
            <div class="card-custom-p mb-4">
                <div class="mb-3">
                    <label class="label-custom">Theme Color</label>
                    <input type="text" name="theme_color" value="{{ $setting->theme_color }}" class="form-control-custom jscolor">
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
