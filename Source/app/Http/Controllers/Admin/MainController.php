<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Cart;
class MainController extends Controller

{
    protected $cart;
    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }
    public function index()
    {
        $totalCustomers = Customer::distinct('name')->count('name');

        // Tính tổng số đơn hàng
        $totalOrders = Customer::distinct('id')->count('id');

        // Tính tổng doanh thu từ các đơn hàng
        $totalSales = Cart::sum('price');

        // Tính tổng doanh thu từ các đơn hàng có trạng thái "Đã giao thành công"
        $totalSalesCompleted = Cart::whereHas('customer', function($query) {
            $query->where('status', 'Đã giao thành công');
        })->sum('price');
        // Lấy danh sách các đơn hàng và tính tổng số tiền cho mỗi đơn hàng
            
        return view('admin.home', [
           'title' => 'Trang Quản Trị Admin',
           'totalCustomers' => $totalCustomers,
           'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'totalSalesCompleted' => $totalSalesCompleted,
            'customers' => $this->cart->getCustomer()->take(5)
        ]);


    }


    // public function show(Customer $customer)
    // {
    //     $carts = $this->cart->getProductForCart($customer);

    //     return view('admin.home', [
    //         // 'title' => 'Chi Tiết Đơn Hàng: ' . $customer->name,
    //         'customer' => $customer,
    //         'carts' => $carts
    //     ]);
    // }
}
