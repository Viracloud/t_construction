<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceFaq;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('id','asc')->get();
        return view('admin.service.index',compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:services,slug',
            'short_description' => 'required|string',
            'description' => 'required|string',
        ]);

        $service = new Service();
        if($request->hasFile('icon')) {
            $final_name = 'service_icon_'.time().'.'.$request->icon->extension();
            $request->icon->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $service->icon = $final_name;
        }
        if($request->hasFile('image')) {
            $final_name = 'service_image_'.time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $service->image = $final_name;
        }
        $service->title = $request->title;
        $service->slug = $request->slug;
        $service->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $service->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $service->short_description = $request->short_description;
        $service->description = $request->description;
        $service->show_on_home = $request->show_on_home;
        $service->phone_text = $request->phone_text;
        $service->phone_number = $request->phone_number;
        $service->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:services,slug,'.$id,
            'short_description' => 'required|string',
            'description' => 'required|string',
        ]);

        $service = Service::where('id', $id)->first();
        if($request->hasFile('icon')) {
            $request->validate([
                'icon' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'service_icon_'.time().'.'.$request->icon->extension();
            if($service->icon && file_exists(public_path('uploads/'.$service->icon))) {
                unlink(public_path('uploads/'.$service->icon));
            }
            $request->icon->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $service->icon = $final_name;
        }
        if($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'service_image_'.time().'.'.$request->image->extension();
            if($service->image && file_exists(public_path('uploads/'.$service->image))) {
                unlink(public_path('uploads/'.$service->image));
            }
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $service->image = $final_name;
        }
        $service->title = $request->title;
        $service->slug = $request->slug;
        $service->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $service->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $service->short_description = $request->short_description;
        $service->description = $request->description;
        $service->show_on_home = $request->show_on_home;
        $service->phone_text = $request->phone_text;
        $service->phone_number = $request->phone_number;
        $service->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function delete($id)
    {

        ServiceFaq::where('service_id', $id)->delete();

        $service = Service::where('id', $id)->first();
        if($service->image && file_exists(public_path('uploads/'.$service->image))) {
            unlink(public_path('uploads/'.$service->image));
        }
        if($service->icon && file_exists(public_path('uploads/'.$service->icon))) {
            unlink(public_path('uploads/'.$service->icon));
        }
        $service->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    public function faqs($service_id)
    {
        $service = Service::where('id', $service_id)->first();
        $service_faqs = ServiceFaq::where('service_id', $service_id)->get();
        return view('admin.service.faq', compact('service_faqs', 'service'));
    }

    public function faq_store(Request $request, $service_id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $obj = new ServiceFaq();
        $obj->service_id = $service_id;
        $obj->question = $request->question;
        $obj->answer = $request->answer;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function faq_update(Request $request, $faq_id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $obj = ServiceFaq::where('id', $faq_id)->first();
        $obj->question = $request->question;
        $obj->answer = $request->answer;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function faq_delete(Request $request, $faq_id)
    {
        $obj = ServiceFaq::where('id', $faq_id)->first();
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
