<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageCartItem;

class AdminPageCartItemController extends Controller
{
    public function index()
    {
        $page_data = PageCartItem::where('id',1)->first();
        return view('admin.page_item.cart',compact('page_data'));
    }

    public function update(Request $request)
    {
        $obj = PageCartItem::where('id', 1)->first();

        $obj->cart_page_title = $request->cart_page_title;
        $obj->checkout_page_title = $request->checkout_page_title;
        $obj->seo_title = $request->seo_title;
        $obj->seo_meta_description = $request->seo_meta_description;

        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }
}
