<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomPage;

class AdminCustomPageController extends Controller
{
    public function index()
    {
        $custom_pages = CustomPage::orderBy('id','asc')->get();
        return view('admin.custom_page.index',compact('custom_pages'));
    }

    public function store(Request $request)
    {
        // "/my-page/" or " my-page " would create a broken URL: keep only the slug itself
        $request->merge(['slug' => trim((string) $request->slug, " 	/")]);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|max:255|unique:custom_pages,slug',
            'content' => 'required|string',
        ]);

        $custom_page = new CustomPage();
        $custom_page->title = $request->title;
        $custom_page->slug = $request->slug;
        $custom_page->content = $request->content;
        $custom_page->seo_title = $request->seo_title;
        $custom_page->seo_meta_description = $request->seo_meta_description;
        $custom_page->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        // "/my-page/" or " my-page " would create a broken URL: keep only the slug itself
        $request->merge(['slug' => trim((string) $request->slug, " 	/")]);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|max:255|unique:custom_pages,slug,' . $id,
            'content' => 'required|string',
        ]);

        $custom_page = CustomPage::where('id', $id)->first();
        $custom_page->title = $request->title;
        $custom_page->slug = $request->slug;
        $custom_page->content = $request->content;
        $custom_page->seo_title = $request->seo_title;
        $custom_page->seo_meta_description = $request->seo_meta_description;
        $custom_page->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function delete($id)
    {
        $custom_page = CustomPage::where('id', $id)->first();
        $custom_page->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
