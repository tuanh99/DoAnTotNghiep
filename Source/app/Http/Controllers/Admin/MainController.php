<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class MainController extends Controller

{
    protected $cart;
    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }
    public function index()
    {
        
        // // Doanh thu theo thang
        // $monthlyRevenues = DB::table('orders')->where('status', 'Đã giao thành công')
        //     ->select(DB::raw('MONTH(updated_at) as month'), DB::raw('YEAR(updated_at) as year'),
        //         DB::raw('SUM(total_amount) as total_revenue'))
        //     ->groupBy('year', 'month')
        //     ->orderBy('year', 'desc')
        //     ->orderBy('month', 'desc')
        //     ->get();

        //  // Chi phi nhap hang da ban theo thang
        //  $monthlyCosts = DB::table('carts')
        //  ->join('products', 'carts.product_id', '=', 'products.id')
        //  ->join('customers', 'customers.id', '=', 'carts.customer_id')
        //  ->join('orders', 'orders.customer_id', '=', 'customers.id')
        //  ->select(DB::raw('MONTH(carts.created_at) as month'), DB::raw('YEAR(carts.created_at) as year'),
        //      DB::raw('SUM(carts.pty * products.price_cost) as total_cost'))
        //     ->where('orders.status', 'Đã giao thành công')
        //     ->groupBy('year', 'month')
        //     ->orderBy('year', 'desc')
        //     ->orderBy('month', 'desc')
        //     ->get();

        // //Loi nhuan
        //  $profits = [];
        //  foreach ($monthlyRevenues as $revenue) {
        //     $monthKey = $revenue->year . '-' . str_pad($revenue->month, 2, '0', STR_PAD_LEFT);
        //     $totalCost = 0;
        //     foreach ($monthlyCosts as $cost) {
        //         if ($cost->year == $revenue->year && $cost->month == $revenue->month) {
        //             $totalCost = $cost->total_cost;
        //             break;
        //         }
        //     }
        //     $profits[$monthKey] = $revenue->total_revenue - $totalCost;
        // }


        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Doanh thu theo tháng
        $monthlyRevenues = DB::table('orders')
            ->where('status', 'Đã giao thành công')
            ->select(
                DB::raw('MONTH(CONVERT_TZ(updated_at, "+00:00", "+07:00")) as month'),
                DB::raw('YEAR(CONVERT_TZ(updated_at, "+00:00", "+07:00")) as year'),
                DB::raw('SUM(total_amount) as total_revenue'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();


        // Chi phí nhập hàng đã bán theo tháng
        $monthlyCosts = DB::table('order_details')
            ->join('products', 'order_details.product_name', '=', 'products.name')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'Đã giao thành công')
            ->select(
                DB::raw('MONTH(CONVERT_TZ(orders.updated_at, "+00:00", "+07:00")) as month'),
                DB::raw('YEAR(CONVERT_TZ(orders.updated_at, "+00:00", "+07:00")) as year'),
                DB::raw('SUM(order_details.product_quantity * products.price_cost) as total_cost')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Lợi nhuận
        $profits = [];
        foreach ($monthlyRevenues as $revenue) {
            $monthKey = $revenue->year . '-' . str_pad($revenue->month, 2, '0', STR_PAD_LEFT);
            $totalCost = 0;
            foreach ($monthlyCosts as $cost) {
                if ($cost->year == $revenue->year && $cost->month == $revenue->month) {
                    $totalCost = $cost->total_cost;
                    break;
                }
            }
            $profits[$monthKey] = $revenue->total_revenue - $totalCost;
        }



        // $dailyRevenues = DB::table('orders')
        // ->where('status', 'Đã giao thành công')
        // ->select(DB::raw('DATE(CONVERT_TZ(updated_at, "+00:00", "+07:00")) as date'), 
        //         DB::raw('SUM(total_amount) as total_revenue'), 
        //         DB::raw('COUNT(*) as total_orders'))
        //     ->groupBy('date')
        //     ->orderBy('date', 'desc')
        //     ->get();


        // Doanh thu và chi phí theo ngày trong tháng hiện tại
            $dailyRevenues = DB::table('orders')
            ->where('status', 'Đã giao thành công')
            ->whereRaw('MONTH(CONVERT_TZ(updated_at, "+00:00", "+07:00")) = ?', [$currentMonth])
            ->whereRaw('YEAR(CONVERT_TZ(updated_at, "+00:00", "+07:00")) = ?', [$currentYear])
            ->select(
                DB::raw('DATE(CONVERT_TZ(updated_at, "+00:00", "+07:00")) as date'),
                DB::raw('SUM(total_amount) as total_revenue'),
                DB::raw('COUNT(id) as total_orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        $dailyCosts = DB::table('order_details')
            ->join('products', 'order_details.product_name', '=', 'products.name')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'Đã giao thành công')
            ->whereRaw('MONTH(CONVERT_TZ(orders.updated_at, "+00:00", "+07:00")) = ?', [$currentMonth])
            ->whereRaw('YEAR(CONVERT_TZ(orders.updated_at, "+00:00", "+07:00")) = ?', [$currentYear])
            ->select(
                DB::raw('DATE(CONVERT_TZ(orders.updated_at, "+00:00", "+07:00")) as date'),
                DB::raw('SUM(order_details.product_quantity * products.price_cost) as total_cost')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        // Lợi nhuận hàng ngày
        $dailyProfits = [];
        foreach ($dailyRevenues as $dailyRevenue) {
            $dateKey = $dailyRevenue->date;
            $totalCost = 0;
            foreach ($dailyCosts as $dailyCost) {
                if ($dailyCost->date == $dailyRevenue->date) {
                    $totalCost = $dailyCost->total_cost;
                    break;
                }
            }
            $dailyProfits[$dateKey] = $dailyRevenue->total_revenue - $totalCost;
        }


            // Tính tổng doanh thu trong tháng hiện tại
        $totalRevenueThisMonth = DB::table('orders')
            ->where('status', 'Đã giao thành công')
            ->whereRaw('MONTH(CONVERT_TZ(updated_at, "+00:00", "+07:00")) = ?', [$currentMonth])
            ->whereRaw('YEAR(CONVERT_TZ(updated_at, "+00:00", "+07:00")) = ?', [$currentYear])
            ->sum('total_amount');
        
        // Tính tổng số hóa đơn trong tháng hiện tại
        $totalOrdersThisMonth = DB::table('orders')
            ->where('status', 'Đã giao thành công')
            ->whereRaw('MONTH(CONVERT_TZ(updated_at, "+00:00", "+07:00")) = ?', [$currentMonth])
            ->whereRaw('YEAR(CONVERT_TZ(updated_at, "+00:00", "+07:00")) = ?', [$currentYear])
            ->count();
            
        $ordersToday = $this->getOrdersToday();
        $topSellingProducts = $this->topSellingProducts();
        return view('admin.home', [
           'title' => 'Trang Quản Trị Admin',
            'ordersToday' => $ordersToday['orders'],
            'totalRevenue' => $ordersToday['totalRevenue'],
            'totalRevenueThisMonth' => $totalRevenueThisMonth,
            'topSellingProducts' => $topSellingProducts,
            'dailyRevenues' => $dailyRevenues,
            'dailyProfits' => $dailyProfits,
            'totalOrdersThisMonth' => $totalOrdersThisMonth,
            // 'revenues' => $revenues,
            'monthlyRevenues'=> $monthlyRevenues,
            'totalOrdersThisMonth' => $totalOrdersThisMonth,
            'profits' => $profits,
            
        ]);

    }

    

    //top sp bán chạy
    public function topSellingProducts()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return OrderDetail::select(
                'products.name as product_name', 
                'menus.name as menu_name',
                DB::raw('SUM(order_details.product_quantity) as total_sold'),
                DB::raw('MONTH(CONVERT_TZ(orders.updated_at, "+00:00", "+07:00")) as month'),
                DB::raw('YEAR(CONVERT_TZ(orders.updated_at, "+00:00", "+07:00")) as year')
            )
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_name', '=', 'products.name') 
            ->join('menus', 'products.menu_id', '=', 'menus.id')
            ->where('orders.status', 'Đã giao thành công')
            ->whereRaw('MONTH(CONVERT_TZ(orders.updated_at, "+00:00", "+07:00")) = ?', [$currentMonth])
            ->whereRaw('YEAR(CONVERT_TZ(orders.updated_at, "+00:00", "+07:00")) = ?', [$currentYear])
            ->groupBy('products.name', 'menus.name', 'month', 'year')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
    }

    // đơn hàng trong ngày và tinsh tổng doanh thu trong ngày
    public function getOrdersToday()
    {
        // $today = Carbon::today();
        $today = Carbon::today()->toDateString(); // Lấy ngày hôm nay dưới dạng chuỗi

        $orders = Order::select(
                'id',
                'customer_name',
                'email',
                'phone',
                'total_amount'
            )
            ->whereDate('updated_at', $today)
            // ->whereRaw('DATE('updated_at', [$today])
            ->where('status', 'Đã giao thành công')
            ->get();

        $totalRevenue = $orders->sum('total_amount');

        return [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
        ];
    }
}