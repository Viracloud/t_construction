<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectFaq;

class AdminProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('id','asc')->get();
        return view('admin.project.index',compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:projects,slug',
            'short_description' => 'required|string',
            'description' => 'required|string',
        ]);

        $obj = new Project();
        if($request->hasFile('image')) {
            $final_name = 'project_image_'.time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->image = $final_name;
        }
        $obj->title = $request->title;
        $obj->slug = $request->slug;
        $obj->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $obj->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;
        $obj->show_on_home = $request->show_on_home;
        $obj->start_date = $request->start_date;
        $obj->end_date = $request->end_date;
        $obj->location = $request->location;
        $obj->manager = $request->manager;
        $obj->budget = $request->budget;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:projects,slug,'.$id,
            'short_description' => 'required|string',
            'description' => 'required|string',
        ]);

        $obj = Project::where('id', $id)->first();
        if($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'project_image_'.time().'.'.$request->image->extension();
            if($obj->image && file_exists(public_path('uploads/'.$obj->image))) {
                unlink(public_path('uploads/'.$obj->image));
            }
            $request->image->move(public_path('uploads'), $final_name);
            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $obj->image = $final_name;
        }
        $obj->title = $request->title;
        $obj->slug = $request->slug;
        $obj->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $obj->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $obj->short_description = $request->short_description;
        $obj->description = $request->description;
        $obj->show_on_home = $request->show_on_home;
        $obj->start_date = $request->start_date;
        $obj->end_date = $request->end_date;
        $obj->location = $request->location;
        $obj->manager = $request->manager;
        $obj->budget = $request->budget;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function delete($id)
    {

        ProjectFaq::where('project_id', $id)->delete();

        $obj = Project::where('id', $id)->first();
        if($obj->image && file_exists(public_path('uploads/'.$obj->image))) {
            unlink(public_path('uploads/'.$obj->image));
        }
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    public function faqs($project_id)
    {
        $project = Project::where('id', $project_id)->first();
        $project_faqs = ProjectFaq::where('project_id', $project_id)->get();
        return view('admin.project.faq', compact('project_faqs', 'project'));
    }

    public function faq_store(Request $request, $project_id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $obj = new ProjectFaq();
        $obj->project_id = $project_id;
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

        $obj = ProjectFaq::where('id', $faq_id)->first();
        $obj->question = $request->question;
        $obj->answer = $request->answer;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function faq_delete(Request $request, $faq_id)
    {
        $obj = ProjectFaq::where('id', $faq_id)->first();
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
