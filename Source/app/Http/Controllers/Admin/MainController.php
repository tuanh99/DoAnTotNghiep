<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Cart;
use App\Models\Product;
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

        // $totalSold = Cart::whereHas('customer', function($query) {
        //     $query->where('status', 'Đã giao thành công');
        // })->sum('pty');


        $topSellingProducts = $this->topSellingProducts();
        return view('admin.home', [
           'title' => 'Trang Quản Trị Admin',
           'totalCustomers' => $totalCustomers,
           'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'totalSalesCompleted' => $totalSalesCompleted,
            // 'totalSold' => $totalSold,
            'topSellingProducts' => $topSellingProducts,
            'customers' => $this->cart->getCustomer()->take(6)
        ]);


    }
    public function topSellingProducts()
    {
        return Product::select('products.id', 'products.name','menus.name as menu_name', \DB::raw('SUM(carts.pty) as total_sold'))
            ->join('carts', 'products.id', '=', 'carts.product_id')
            ->join('customers', 'carts.customer_id', '=', 'customers.id')
            ->join('menus', 'products.menu_id', '=', 'menus.id')
            ->where('customers.status', 'Đã giao thành công')
            ->groupBy('products.id', 'products.name', 'menus.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
            
    }
}
