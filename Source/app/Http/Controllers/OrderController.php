<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth('user')->id())->get();
        return view('orders.list', ['title'=> "Danh sách đơn hàng"],  compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('user.orders')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }
    public function showDetail($id)
    {
        $order = Order::find($id);
        $title = 'Chi tiết đơn hàng ' . $order->id;
        return view('orders.detail', compact('order','title'));
    }
}