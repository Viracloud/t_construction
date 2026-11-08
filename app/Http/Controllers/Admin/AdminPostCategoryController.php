<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Models\Post;

class AdminPostCategoryController extends Controller
{
    public function index()
    {
        $post_categories = PostCategory::orderBy('id','asc')->get();
        return view('admin.post_category.index',compact('post_categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:post_categories,name',
            'slug' => 'required|alpha_dash|unique:post_categories,slug',
        ]);

        $obj = new PostCategory();
        $obj->name = $request->name;
        $obj->slug = $request->slug;
        $obj->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $obj->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:post_categories,name,'.$id,
            'slug' => 'required|alpha_dash|unique:post_categories,slug,'.$id,
        ]);

        $obj = PostCategory::where('id', $id)->first();
        $obj->name = $request->name;
        $obj->slug = $request->slug;
        $obj->seo_title = filled($request->seo_title) ? mb_substr(trim($request->seo_title), 0, 255) : null;
        $obj->seo_meta_description = filled($request->seo_meta_description) ? trim($request->seo_meta_description) : null;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function delete($id)
    {
        $total = Post::where('post_category_id', $id)->count();

        if($total > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with associated posts.');
        }

        $obj = PostCategory::where('id', $id)->first();
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
