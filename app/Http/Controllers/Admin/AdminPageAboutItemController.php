<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageAboutItem;

class AdminPageAboutItemController extends Controller
{
    public function index()
    {
        $page_data = PageAboutItem::where('id',1)->first();
        return view('admin.page_item.about',compact('page_data'));
    }

    public function update(Request $request)
    {
        $obj = PageAboutItem::where('id', 1)->first();
        
        $obj->about_status = $request->about_status;
        
        $obj->service_subheading = $request->service_subheading;
        $obj->service_heading = $request->service_heading;
        $obj->service_text = $request->service_text;
        $obj->service_status = $request->service_status;
        
        $obj->testimonial_subheading = $request->testimonial_subheading;
        $obj->testimonial_heading = $request->testimonial_heading;
        $obj->testimonial_status = $request->testimonial_status;

        $obj->seo_title = $request->seo_title;
        $obj->seo_meta_description = $request->seo_meta_description;

        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }
}
