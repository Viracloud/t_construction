@extends('admin.layouts.master')
@section('content')
<div class="page-heading">
    <h1>Settings - SEO &amp; Google</h1>
    <p>Used for the site title, social sharing previews, Google business information (structured data) and Google Analytics / Google Ads tracking.</p>
</div>

<form action="{{ route('admin_setting_seo_update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-12 col-xl-12">

            <h6 class="cus-heading">General</h6>
            <div class="card-custom-p mb-4">
                <div class="mb-3">
                    <label class="label-custom">Business / Site Name *</label>
                    <input type="text" name="site_name" value="{{ $setting->site_name }}" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="label-custom">Default Social Share Image <small class="text-muted">(1200 x 630 px recommended; shown when a page is shared on Facebook, WhatsApp, LinkedIn)</small></label>
                    @if($setting->og_image)
                    <div class="mb-2"><img src="{{ asset('uploads/'.$setting->og_image) }}" alt="Social share image" style="max-width:300px"></div>
                    @endif
                    <input type="file" name="og_image" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="label-custom">Google Search Console Verification Code <small class="text-muted">(only the content value, e.g. abc123XYZ)</small></label>
                    <input type="text" name="google_site_verification" value="{{ $setting->google_site_verification }}" class="form-control-custom">
                </div>
            </div>

            <h6 class="cus-heading">Business Information (Google Local SEO)</h6>
            <div class="card-custom-p mb-4">
                <p class="text-sm text-gray-500">Must exactly match your Google Business Profile. Phone and email are taken from Settings &rarr; Top Bar.</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="label-custom">Business Type</label>
                        <select name="business_type" class="form-control-custom">
                            @foreach(['GeneralContractor','HomeAndConstructionBusiness','HousePainter','RoofingContractor','Plumber','Electrician','LocalBusiness'] as $type)
                            <option value="{{ $type }}" {{ $setting->business_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="label-custom">Street Address</label>
                        <input type="text" name="business_street" value="{{ $setting->business_street }}" class="form-control-custom">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="label-custom">City / Suburb</label>
                        <input type="text" name="business_city" value="{{ $setting->business_city }}" class="form-control-custom">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="label-custom">State</label>
                        <input type="text" name="business_state" value="{{ $setting->business_state }}" class="form-control-custom">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="label-custom">Postcode</label>
                        <input type="text" name="business_postcode" value="{{ $setting->business_postcode }}" class="form-control-custom">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="label-custom">Country Code</label>
                        <input type="text" name="business_country" value="{{ $setting->business_country }}" class="form-control-custom">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="label-custom">Areas Served <small class="text-muted">(comma separated, e.g. Sydney, Parramatta, North Shore)</small></label>
                        <input type="text" name="business_area_served" value="{{ $setting->business_area_served }}" class="form-control-custom">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="label-custom">Opening Hours <small class="text-muted">(e.g. Mo-Fr 07:00-17:00, Sa 08:00-12:00)</small></label>
                        <input type="text" name="business_opening_hours" value="{{ $setting->business_opening_hours }}" class="form-control-custom">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="label-custom">Latitude <small class="text-muted">(optional)</small></label>
                        <input type="text" name="business_latitude" value="{{ $setting->business_latitude }}" class="form-control-custom">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="label-custom">Longitude <small class="text-muted">(optional)</small></label>
                        <input type="text" name="business_longitude" value="{{ $setting->business_longitude }}" class="form-control-custom">
                    </div>
                </div>
            </div>

            <h6 class="cus-heading">Google Analytics &amp; Google Ads</h6>
            <div class="card-custom-p mb-4">
                <p class="text-sm text-gray-500">Leave empty until you have the IDs. Nothing is loaded while these are empty.</p>
                <div class="mb-3">
                    <label class="label-custom">Google Analytics 4 Measurement ID <small class="text-muted">(e.g. G-XXXXXXXXXX)</small></label>
                    <input type="text" name="google_tag_id" value="{{ $setting->google_tag_id }}" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="label-custom">Google Ads ID <small class="text-muted">(e.g. AW-123456789)</small></label>
                    <input type="text" name="google_ads_id" value="{{ $setting->google_ads_id }}" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="label-custom">Google Ads Conversion Label - Form Lead <small class="text-muted">(fires after a contact / service enquiry form is sent)</small></label>
                    <input type="text" name="google_ads_label_lead" value="{{ $setting->google_ads_label_lead }}" class="form-control-custom">
                </div>
                <div class="mb-3">
                    <label class="label-custom">Google Ads Conversion Label - Phone Click <small class="text-muted">(fires when a visitor taps a phone number)</small></label>
                    <input type="text" name="google_ads_label_phone" value="{{ $setting->google_ads_label_phone }}" class="form-control-custom">
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
