<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutItem;

class AdminAboutItemController extends Controller
{
    public function index()
    {
        $about_item = AboutItem::where('id',1)->first();
        return view('admin.about_item.index',compact('about_item'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'text' => 'required|string',
        ]);

        $obj = AboutItem::where('id', 1)->first();
        if($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'about_item_'.time().'.'.$request->image->extension();
            if($obj->image && file_exists(public_path('uploads/'.$obj->image))) {
                unlink(public_path('uploads/'.$obj->image));
            }
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->image = $final_name;
        }
        $obj->heading = $request->heading;
        $obj->text = $request->text;
        $obj->subheading = $request->subheading;
        $obj->experience_year = $request->experience_year;
        $obj->experience_text = $request->experience_text;
        $obj->youtube_id = $request->youtube_id;
        $obj->phone_number = $request->phone_number;
        $obj->phone_text = $request->phone_text;
        $obj->button_text = $request->button_text;
        $obj->button_link = $request->button_link;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }
}
