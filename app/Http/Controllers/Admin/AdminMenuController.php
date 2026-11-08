<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class AdminMenuController extends Controller
{
    public function index()
    {
        $menu = Menu::where('id',1)->first();
        return view('admin.menu.index',compact('menu'));
    }

    public function update(Request $request)
    {
        $obj = Menu::where('id', 1)->first();
        $obj->menu_home_name = $request->menu_home_name;
        $obj->menu_home_status = $request->menu_home_status;
        $obj->menu_about_name = $request->menu_about_name;
        $obj->menu_about_status = $request->menu_about_status;
        $obj->menu_service_name = $request->menu_service_name;
        $obj->menu_service_status = $request->menu_service_status;
        $obj->menu_event_name = $request->menu_event_name;
        $obj->menu_event_status = $request->menu_event_status;
        $obj->menu_team_member_name = $request->menu_team_member_name;
        $obj->menu_team_member_status = $request->menu_team_member_status;
        $obj->menu_project_name = $request->menu_project_name;
        $obj->menu_project_status = $request->menu_project_status;
        $obj->menu_shop_name = $request->menu_shop_name;
        $obj->menu_shop_status = $request->menu_shop_status;
        $obj->menu_gallery_name = $request->menu_gallery_name;
        $obj->menu_gallery_status = $request->menu_gallery_status;
        $obj->menu_faq_name = $request->menu_faq_name;
        $obj->menu_faq_status = $request->menu_faq_status;
        $obj->menu_blog_name = $request->menu_blog_name;
        $obj->menu_blog_status = $request->menu_blog_status;
        $obj->menu_contact_name = $request->menu_contact_name;
        $obj->menu_contact_status = $request->menu_contact_status;
        $obj->menu_login_name = $request->menu_login_name;
        $obj->menu_login_status = $request->menu_login_status;
        $obj->menu_cart_status = $request->menu_cart_status;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }
}
