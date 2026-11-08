<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class AdminOrderController extends Controller
{
    public function orders()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('admin.order.orders', compact('orders'));
    }

    public function change_status(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)->first();
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status changed successfully.');
    }

    public function invoice($order_no)
    {
        $order = Order::where('order_no', $order_no)->first();
        $order_details = OrderDetail::where('order_id', $order->id)->get();
        return view('admin.order.invoice', compact('order', 'order_details'));
    }

    public function delete($id)
    {
        Order::where('id', $id)->delete();
        OrderDetail::where('order_id', $id)->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
