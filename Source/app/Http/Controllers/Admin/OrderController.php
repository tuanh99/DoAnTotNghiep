<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10); 
        $customers = Customer::orderBy('created_at', 'desc')->paginate(10); 
        return view('admin.orders.order', ['title' => 'Danh sách hóa đơn'], compact('orders', 'customers'));
    }
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Đang chuẩn bị,Đang giao hàng,Đã giao thành công,Hủy',
        ]);

        $order->status = $request->status;

        $oldStatus = $order->status;
        $newStatus = $request->input('status');
        
        if ($oldStatus != $newStatus) {
            // Cập nhật trạng thái đơn hàng
            $order->status = $newStatus;
            $order->status_updated_at = now();
            // $order->save();
        }
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
    public function showDetail($id)
    {
        $order = Order::find($id);
        $title = 'Chi tiết đơn hàng ' . $order->id;
        return view('admin.orders.detail', compact('order','title'));
    }
}