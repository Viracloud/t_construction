<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id','asc')->get();
        return view('admin.coupon.index',compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code|max:255',
            'percentage' => 'required|numeric',
            'usage_limit' => 'required|integer',
            'start_date' => 'required|date',
            'expire_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Active,Inactive',
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->percentage = $request->percentage;
        $coupon->usage_limit = $request->usage_limit;
        $coupon->start_date = $request->start_date;
        $coupon->expire_date = $request->expire_date;
        $coupon->status = $request->status;
        $coupon->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,'.$id.'|max:255',
            'percentage' => 'required|numeric',
            'usage_limit' => 'required|integer',
            'start_date' => 'required|date',
            'expire_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Active,Inactive',
        ]);

        $coupon = Coupon::where('id', $id)->first();
        $coupon->code = $request->code;
        $coupon->percentage = $request->percentage;
        $coupon->usage_limit = $request->usage_limit;
        $coupon->start_date = $request->start_date;
        $coupon->expire_date = $request->expire_date;
        $coupon->status = $request->status;
        $coupon->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function delete($id)
    {
        $coupon = Coupon::where('id', $id)->first();
        $coupon->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
