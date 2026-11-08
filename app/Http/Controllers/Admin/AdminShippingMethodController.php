<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;

class AdminShippingMethodController extends Controller
{
    public function index()
    {
        $shipping_methods = ShippingMethod::orderBy('id','asc')->get();
        return view('admin.shipping_method.index',compact('shipping_methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:shipping_methods,name|max:255',
            'cost' => 'required|numeric',
            'estimated_days' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $obj = new ShippingMethod();
        $obj->name = $request->name;
        $obj->cost = $request->cost;
        $obj->estimated_days = $request->estimated_days;
        $obj->status = $request->status;
        $obj->save();

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:shipping_methods,name,'.$id.'|max:255',
            'cost' => 'required|numeric',
            'estimated_days' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $obj = ShippingMethod::where('id', $id)->first();
        $obj->name = $request->name;
        $obj->cost = $request->cost;
        $obj->estimated_days = $request->estimated_days;
        $obj->status = $request->status;
        $obj->save();

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function delete($id)
    {
        $obj = ShippingMethod::where('id', $id)->first();
        $obj->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
