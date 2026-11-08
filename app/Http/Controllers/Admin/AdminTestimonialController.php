<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('id','asc')->get();
        return view('admin.testimonial.index',compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        $testimonial = new Testimonial();
        if($request->hasFile('image')) {
            $final_name = 'testimonial_'.time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $testimonial->image = $final_name;
        }
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->comment = $request->comment;
        $testimonial->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        $testimonial = Testimonial::where('id', $id)->first();
        if($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'testimonial_'.time().'.'.$request->image->extension();
            if($testimonial->image && file_exists(public_path('uploads/'.$testimonial->image))) {
                unlink(public_path('uploads/'.$testimonial->image));
            }
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $testimonial->image = $final_name;
        }
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->comment = $request->comment;
        $testimonial->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function delete($id)
    {
        $testimonial = Testimonial::where('id', $id)->first();
        if($testimonial->image && file_exists(public_path('uploads/'.$testimonial->image))) {
            unlink(public_path('uploads/'.$testimonial->image));
        }
        $testimonial->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
