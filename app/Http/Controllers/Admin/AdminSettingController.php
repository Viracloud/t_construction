<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingController extends Controller
{
    public function logo()
    {
        $setting = Setting::where('id',1)->first();
        return view('admin.setting.logo',compact('setting'));
    }

    public function logo_update(Request $request)
    {
        $setting = Setting::where('id',1)->first();

        if($request->hasFile('logo_1')) {
            $request->validate(['logo_1' => 'mimes:jpeg,png,jpg,gif,svg|max:2048']);
            $final_name = 'logo_1_'.time().'.'.$request->logo_1->extension();
            if($setting->logo_1 && file_exists(public_path('uploads/'.$setting->logo_1))) {
                unlink(public_path('uploads/'.$setting->logo_1));
            }
            $request->logo_1->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $setting->logo_1 = $final_name;
        }

        if($request->hasFile('logo_2')) {
            $request->validate(['logo_2' => 'mimes:jpeg,png,jpg,gif,svg|max:2048']);
            $final_name = 'logo_2_'.time().'.'.$request->logo_2->extension();
            if($setting->logo_2 && file_exists(public_path('uploads/'.$setting->logo_2))) {
                unlink(public_path('uploads/'.$setting->logo_2));
            }
            $request->logo_2->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $setting->logo_2 = $final_name;
        }

        $setting->save();
        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function favicon()
    {
        $setting = Setting::where('id',1)->first();
        return view('admin.setting.favicon',compact('setting'));
    }

    public function favicon_update(Request $request)
    {
        $setting = Setting::where('id',1)->first();

        if($request->hasFile('favicon')) {
            $request->validate(['favicon' => 'mimes:jpeg,png,jpg,gif,svg,ico|max:2048']);
            $final_name = 'favicon_'.time().'.'.$request->favicon->extension();
            if($setting->favicon && file_exists(public_path('uploads/'.$setting->favicon))) {
                unlink(public_path('uploads/'.$setting->favicon));
            }
            $request->favicon->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $setting->favicon = $final_name;
        }

        $setting->save();
        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function banner()
    {
        $setting = Setting::where('id',1)->first();
        return view('admin.setting.banner',compact('setting'));
    }

    public function banner_update(Request $request)
    {
        $setting = Setting::where('id',1)->first();

        if($request->hasFile('banner')) {
            $request->validate(['banner' => 'mimes:jpeg,png,jpg,gif,svg|max:2048']);
            $final_name = 'banner_'.time().'.'.$request->banner->extension();
            if($setting->banner && file_exists(public_path('uploads/'.$setting->banner))) {
                unlink(public_path('uploads/'.$setting->banner));
            }
            $request->banner->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $setting->banner = $final_name;
        }

        $setting->save();
        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function top_bar()
    {
        $setting = Setting::where('id',1)->first();
        return view('admin.setting.top_bar',compact('setting'));
    }

    public function top_bar_update(Request $request)
    {
        $setting = Setting::where('id',1)->first();

        $setting->top_bar_email = $request->top_bar_email;
        $setting->top_bar_phone = $request->top_bar_phone;
        $setting->top_bar_address = $request->top_bar_address;
        $setting->top_bar_facebook = $request->top_bar_facebook;
        $setting->top_bar_twitter = $request->top_bar_twitter;
        $setting->top_bar_linkedin = $request->top_bar_linkedin;
        $setting->top_bar_instagram = $request->top_bar_instagram;

        $setting->save();
        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function footer()
    {
        $setting = Setting::where('id',1)->first();
        return view('admin.setting.footer',compact('setting'));
    }

    public function footer_update(Request $request)
    {
        $setting = Setting::where('id',1)->first();

        $setting->footer_facebook = $request->footer_facebook;
        $setting->footer_twitter = $request->footer_twitter;
        $setting->footer_linkedin = $request->footer_linkedin;
        $setting->footer_instagram = $request->footer_instagram;
        $setting->footer_phone = $request->footer_phone;
        $setting->footer_email = $request->footer_email;
        $setting->footer_copyright = $request->footer_copyright;

        $setting->save();
        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function theme_color()
    {
        $setting = Setting::where('id',1)->first();
        return view('admin.setting.theme_color',compact('setting'));
    }

    public function theme_color_update(Request $request)
    {
        $setting = Setting::where('id',1)->first();

        $setting->theme_color = $request->theme_color;

        $setting->save();
        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function seo()
    {
        $setting = Setting::where('id',1)->first();
        return view('admin.setting.seo',compact('setting'));
    }

    public function seo_update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'google_tag_id' => ['nullable', 'regex:/^G-[A-Z0-9]+$/i'],
            'google_ads_id' => ['nullable', 'regex:/^AW-[0-9]+$/i'],
            'business_latitude' => 'nullable|numeric',
            'business_longitude' => 'nullable|numeric',
        ]);

        $setting = Setting::where('id',1)->first();

        if($request->hasFile('og_image')) {
            $request->validate(['og_image' => 'mimes:jpeg,png,jpg,webp|max:4096']);
            $final_name = 'og_image_'.time().'.'.$request->og_image->extension();
            if($setting->og_image && file_exists(public_path('uploads/'.$setting->og_image))) {
                unlink(public_path('uploads/'.$setting->og_image));
            }
            $request->og_image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $setting->og_image = $final_name;
        }

        $fields = [
            'site_name', 'google_site_verification', 'google_tag_id', 'google_ads_id',
            'google_ads_label_lead', 'google_ads_label_phone', 'business_type', 'business_street',
            'business_city', 'business_state', 'business_postcode', 'business_country',
            'business_area_served', 'business_opening_hours', 'business_latitude', 'business_longitude',
        ];
        foreach($fields as $field) {
            $value = $request->input($field);
            $value = is_string($value) ? trim($value) : $value;
            $setting->$field = ($value === '') ? null : $value;
        }

        // Accept the full meta tag pasted from Search Console: keep only the content value
        if ($setting->google_site_verification && preg_match('/content=["\']([^"\']+)["\']/i', $setting->google_site_verification, $m)) {
            $setting->google_site_verification = $m[1];
        }
        // Accept "AW-123456789/AbCdEf" pasted into a label field: keep only the label part
        foreach (['google_ads_label_lead', 'google_ads_label_phone'] as $field) {
            if ($setting->$field && str_contains($setting->$field, '/')) {
                $setting->$field = trim(substr(strrchr($setting->$field, '/'), 1));
            }
        }
        $setting->google_tag_id = $setting->google_tag_id ? strtoupper($setting->google_tag_id) : null;
        $setting->google_ads_id = $setting->google_ads_id ? strtoupper($setting->google_ads_id) : null;

        $setting->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function layout_direction()
    {
        $setting = Setting::where('id',1)->first();
        return view('admin.setting.layout_direction',compact('setting'));
    }

    public function layout_direction_update(Request $request)
    {
        $setting = Setting::where('id',1)->first();

        $setting->layout_direction = $request->layout_direction;

        $setting->save();
        return redirect()->back()->with('success', 'Item updated successfully.');
    }
}
