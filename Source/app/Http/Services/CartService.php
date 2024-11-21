<?php


namespace App\Http\Services;


use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
class CartService
{
    // public function create($request)
    // {
    //     $qty = (int)$request->input('num_product');
    //     $product_id = (int)$request->input('product_id');

    //     if ($qty <= 0 || $product_id <= 0) {
    //         Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
    //         return false;
    //     }

    //     $carts = Session::get('carts');
    //     if (is_null($carts)) {
    //         Session::put('carts', [
    //             $product_id => $qty
    //         ]);
    //         return true;
    //     }

    //     $exists = Arr::exists($carts, $product_id);
    //     if ($exists) {
    //         $carts[$product_id] = $carts[$product_id] + $qty;
    //         Session::put('carts', $carts);
    //         return true;
    //     }

    //     $carts[$product_id] = $qty;
    //     Session::put('carts', $carts);

    //     return true;
    // }

    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');
        $product = Product::find($product_id);
        $product_quantity = $product->stock;

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
            return false;
        }

        if ($product_quantity === null || $product_quantity == 0) {
            Session::flash('error', 'Sản phẩm này hiện đã hết');
            return false;
        }
        if ($qty >$product_quantity) {
            Session::flash('error', 'Số lượng sản phẩm không đủ');
            return false;
        }
         

         // Lấy giỏ hàng hiện tại từ session
         $carts = Session::get('carts');
     
         if (is_null($carts)) {
            Session::put('carts', [
                $product_id => $qty
            ]);
            return true;
        }

        $exists = Arr::exists($carts, $product_id);
        if ($exists) {
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts', $carts);
            return true;
        }

        $carts[$product_id] = $qty;
        Session::put('carts', $carts);

        return true;
    }
    public function getProduct()
    {
            $carts = Session::get('carts');
            if (is_null($carts)) return [];
    
            $productId = array_keys($carts);
            return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
                ->where('active', 1)
                ->whereIn('id', $productId)
                ->get();
    }

    public function update($request)
    {
        $carts = $request->input('num_product');

    // Kiểm tra số lượng tồn kho trước khi cập nhật giỏ hàng
    foreach ($carts as $productId => $quantity) {
        $product = Product::find($productId);
        if ($product && $quantity > $product->stock) {
            Session::flash('error', "Số lượng sản phẩm '{$product->name}' không đủ. Tồn kho hiện tại là {$product->stock}.");
            return false;
        }
    }

    // Nếu tất cả số lượng hợp lệ, cập nhật giỏ hàng
    Session::put('carts', $carts);
    return true;
    }

    public function remove($id)
    {
        $carts = Session::get('carts');
        unset($carts[$id]);

        Session::put('carts', $carts);
        return true;
    }
    //chat
    public function addCart($request)

{
    try {
        DB::beginTransaction();

         // Log bước bắt đầu thêm vào giỏ hàng
         Log::info('Starting add to cart process.');

        $carts = Session::get('carts');

        if (is_null($carts)|| empty($carts)){
            Session::flash('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ.');
            return false;
        }
        // Log trạng thái của giỏ hàng trước khi xử lý
        Log::info('Current carts:', $carts);
        $errors = []; // Mảng lưu trữ các lỗi cho từng sản phẩm
        foreach ($carts as $productId => $qty) {
            $product = Product::find($productId);
            if (!$product) {
                continue; // Bỏ qua sản phẩm không tồn tại
            }

            if ($qty > $product->stock) {
                $errors[] = 'Số lượng sản phẩm "' . $product->name . '" vượt quá số lượng tồn kho. Vui lòng giảm số lượng nhỏ hơn hoặc bằng "' . $product->stock . '"';
            }
        }

        if (!empty($errors)) {
            DB::rollBack(); // Hủy giao dịch nếu có lỗi
            Session::flash('error', implode('<br>', $errors));
            return false;
        }

        //chatt
         // Log trước khi tạo khách hàng mới
         Log::info('Creating new customer.');
        $customer = Customer::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'content' => $request->input('content')
        ]);
        Log::info('Customer created: ', $customer->toArray()); // Log thông tin khách hàng
         // Log trước khi lưu thông tin sản phẩm vào giỏ hàng
         
         // Tạo bản ghi Order mới
        $order = Order::create([
            'user_id' => auth('user')->id(),
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'phone' => $customer->phone,
            'address' => $customer->address,
            'email' => $customer->email,
            'content' => $customer->content,
            'total_amount' => $this->calculateTotalAmount($carts)
        ]);

        //Lưu thông tin vào bảng OrderDetail
        foreach ($carts as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id; 
            $orderDetail->product_name = $product->name;
            $orderDetail->product_quantity = $quantity;
            $orderDetail->product_price = $product->price_sale != 0 ? $product->price_sale : $product->price;
            $orderDetail->save();
            }
        }

        // Log trước khi lưu thông tin sản phẩm vào giỏ hàng
         Log::info('Storing product information in cart.');
        $this->infoProductCart($carts, $customer->id);
        
        // Giảm số lượng tồn kho của các sản phẩm trong giỏ hàng
        foreach ($carts as $productId => $qty) {
            $product = Product::find($productId);
            if ($product) {
                $product->stock -= $qty;
                $product->save();
            }
        }
        
        DB::commit();
        Session::flash('success', 'Đặt hàng thành công');
        $orderDetails = $this->getOrderDetails(Session::get('carts'));
        // $orderUrl = route('customers.detail', ['order' => $customer->id]); // Đường dẫn đến chi tiết đơn hàng

        Mail::to($customer->email)->send(new OrderShipped($customer,$orderDetails));
        Session::forget('carts');
         // Log thành công sau khi hoàn tất đặt hàng
         Log::info('Order placed successfully.');
       

        // // Gửi email với thông tin chi tiết đơn hàng

    }
    catch (\Exception $err) {
        DB::rollBack();
        Session::flash('error', 'Đặt hàng không thành công, vui lòng thử lại');
        Log::error('Order failed: ', ['error' => $err->getMessage()]);
        return false;
    }

    return true;
}

//chatt

    protected function getOrderDetails($carts)
{
    $productId = array_keys($carts);
    $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
        ->where('active', 1)
        ->whereIn('id', $productId)
        ->get();

    $orderDetails = [];
    foreach ($products as $product) {
        $orderDetails[] = [
            'product_name' => $product->name,
            'quantity' => $carts[$product->id],
            'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
        ];
    }

    return $orderDetails;
}


    protected function infoProductCart($carts, $customer_id)
    {
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'pty'   => $carts[$product->id],
                'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
            ];
        }
        return Cart::insert($data);
    }

    public function getCustomer()
    {
        return Customer::orderByDesc('id')->paginate(15);
    }

    public function getProductForCart($customer)
    {
        return $customer->carts()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }

    private function calculateTotalAmount($carts)
{
    $total = 0;
    foreach ($carts as $productId => $qty) {
        $product = Product::find($productId);
        if ($product) {
            $total += $product->price_sale != 0 ? $product->price_sale * $qty : $product->price * $qty;
        }
    }
    return $total;
}
    
}