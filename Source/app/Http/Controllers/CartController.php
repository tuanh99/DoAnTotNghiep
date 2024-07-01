<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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
    // $carts = $request->input('num_product', []);
    // foreach ($carts as $id => $quantity) {
        // Cập nhật giỏ hàng trong session hoặc cơ sở dữ liệu
        // ...

        $result = $this->cartService->update($request);
        if ($result === false) {
            return redirect()->back()->withInput();
        }

        return redirect('/carts');
    }

    // Chuyển hướng trở lại trang giỏ hàng với các giá trị input cũ
    // return redirect()->back()->withInput();


    public function remove($id = 0)
    {
        $this->cartService->remove($id);

        return redirect('/carts');
    }
    //chat
    public function placeOrder(Request $request)
{
    $carts = $request->input('num_product'); // Lấy số lượng từ request
    foreach ($carts as $productId => $quantity) {
        $product = Product::find($productId);
        if ($product->stock < $quantity) {
            return redirect()->back()->withErrors(['msg' => 'Số lượng sản phẩm ' . $product->name . ' vượt quá số lượng tồn kho.']);
        }
    }

    
}
//chatt
    public function addCart(Request $request)
    {
        // $this->cartService->addCart($request);

        // return redirect()->back();}


        // chat
        $result = $this->cartService->addCart($request);
        if ($result === false) {
            return redirect()->back()->withInput();
        }

        return redirect()->back();
    }

    //chat
    public function order(Request $request, CartService $cartService)
{
    $carts = Session::get('carts');

    // Kiểm tra số lượng sản phẩm với số lượng tồn kho
    $checkStock = $cartService->checkStockBeforeOrder($carts);
    if (!$checkStock['status']) {
        return redirect()->back()->with('error', $checkStock['message']);
    }

    // Tiếp tục xử lý đặt hàng
    try {
        DB::beginTransaction();

        $customer = Customer::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'content' => $request->input('content')
        ]);

        $this->infoProductCart($carts, $customer->id);

        // Tạo hóa đơn và lưu trạng thái
        $invoice = Invoice::create([
            'customer_id' => $customer->id,
            'status' => $request->input('status'), // Chọn trạng thái từ form
            // 'total' => $this->infoProductCart($carts, $customer->id)['total'] // Tổng số tiền của hóa đơn
        ]);
        DB::commit();
        Session::flash('success', 'Đặt hàng thành công');
        SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));
        Session::forget('carts');
    } catch (\Exception $err) {
        DB::rollBack();
        Session::flash('error', 'Đặt hàng không thành công, vui lòng thử lại');
        return redirect()->back();
    }

    return redirect()->route('cart.list');
}


}
    
