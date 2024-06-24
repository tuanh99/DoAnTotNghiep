<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $result = $this->cartService->create($request);
        if ($result === false) {
            return redirect()->back();
        }

        return redirect('/carts');
    }

    public function show()
    {
        $products = $this->cartService->getProduct();

        return view('carts.list', [
            'title' => 'Giỏ Hàng',
            'products' => $products,
            'carts' => Session::get('carts')
        ]);
    }

    // public function update(Request $request)
    // {
    //     $this->cartService->update($request);

    //     return redirect('/carts');
    // }

    //chat

    public function update(Request $request)
{
    // Xử lý logic cập nhật giỏ hàng
    $carts = $request->input('num_product', []);
    foreach ($carts as $id => $quantity) {
        // Cập nhật giỏ hàng trong session hoặc cơ sở dữ liệu
        // ...
    }

    // Chuyển hướng trở lại trang giỏ hàng với các giá trị input cũ
    return redirect()->back()->withInput();
}

    public function remove($id = 0)
    {
        $this->cartService->remove($id);

        return redirect('/carts');
    }

    public function addCart(Request $request)
    {
        $this->cartService->addCart($request);

        return redirect()->back();}


        // chat

    //     $result = $this->cartService->addCart($request);
    
    // if ($result === false) {
    //     return redirect()->back();
    // }
    
    // Session::flash('success', 'Đặt hàng thành công');
    
    // return redirect()->route('cart.show');
    // }
    // chatt
}
