<?php


namespace App\Http\Services\Product;


use App\Models\Menu;
use App\Models\Cart;
use App\Http\Services\CartService;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }

    protected function isValidPrice($request)
    {
        if ($request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }

        return  true;
    }

    public function insert($request)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) {
            return redirect()->back()->withInput();
        }
        try {
            $request->except('_token');
            Product::create($request->all());

            Session::flash('success', 'Thêm Sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Sản phẩm lỗi');
            \Log::info($err->getMessage());
            return  false;
        }

        return  true;
    }

    public function get($sortBy = 'id', $sortOrder = 'asc')
    {
        // return Product::select('id', 'name', 'price', 'price_sale', 'stock', 'active', 'updated_at')
            // Lấy sản phẩm kèm theo tổng số lượng đã bán
        // $products = Product::with('menu')
        // ->withCount(['carts as total_sold' => function ($query) {
        //     $query->select(\DB::raw("SUM(pty)"));
        // }])

        // Lấy sản phẩm kèm theo tổng số lượng đã bán
    $products = Product::with('menu')
    ->withCount(['carts as total_sold' => function ($query) {
        $query->whereHas('customer', function ($query) {
            $query->where('status', 'Đã giao thành công');
        })->select(\DB::raw("SUM(pty)"));
    }])
        ->orderBy($sortBy, $sortOrder)
        ->paginate(15);

    return $products;
    }

    public function update($request, $product)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) return false;

        try {
            $product->fill($request->input());
            $product->save();
            Session::flash('success', 'Cập nhật thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Có lỗi vui lòng thử lại');
            \Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        $product = Product::where('id', $request->input('id'))->first();
        if ($product) {
            $product->delete();
            return true;
        }

        return false;
    }
}
