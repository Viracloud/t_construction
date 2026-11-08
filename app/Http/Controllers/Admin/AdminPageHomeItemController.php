<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageHomeItem;

class AdminPageHomeItemController extends Controller
{
    public function index()
    {
        $page_data = PageHomeItem::where('id',1)->first();
        return view('admin.page_item.home',compact('page_data'));
    }

    public function update(Request $request)
    {
        $obj = PageHomeItem::where('id', 1)->first();
        
        $obj->about_status = $request->about_status;
        
        $obj->service_subheading = $request->service_subheading;
        $obj->service_heading = $request->service_heading;
        $obj->service_text = $request->service_text;
        $obj->service_status = $request->service_status;
        
        $obj->project_subheading = $request->project_subheading;
        $obj->project_heading = $request->project_heading;
        $obj->project_text = $request->project_text;
        $obj->project_status = $request->project_status;
        
        $obj->testimonial_subheading = $request->testimonial_subheading;
        $obj->testimonial_heading = $request->testimonial_heading;
        $obj->testimonial_status = $request->testimonial_status;

        $obj->team_subheading = $request->team_subheading;
        $obj->team_heading = $request->team_heading;
        $obj->team_status = $request->team_status;

        $obj->event_subheading = $request->event_subheading;
        $obj->event_heading = $request->event_heading;
        $obj->event_status = $request->event_status;

        $obj->blog_subheading = $request->blog_subheading;
        $obj->blog_heading = $request->blog_heading;
        $obj->blog_status = $request->blog_status;

        $obj->seo_title = $request->seo_title;
        $obj->seo_meta_description = $request->seo_meta_description;

        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }
}
