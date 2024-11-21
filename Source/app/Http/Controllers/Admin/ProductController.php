<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;
use App\Models\Product;
use App\Http\Services\CartService;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{   
    protected $productService;

    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {   
         
         $sortBy = $request->input('sort_by', 'id'); // Mặc định sắp xếp theo id
        $sortOrder = $request->input('sort_order', 'asc'); // Mặc định sắp xếp tăng dần
        $products = $this->productService->get($sortBy, $sortOrder);
        return view('admin.product.list', [
            'title' => 'Danh Sách Sản Phẩm',
            // 'products' => $this->productService->get()
            'products' => $products,
            
        ]);
    }
    
    public function create()
    {
        return view('admin.product.add', [
            'title' => 'Thêm Sản Phẩm Mới',
            'menus' => $this->productService->getMenu()
        ]);
    }


    public function store(ProductRequest $request)
    {
        $this->productService->insert($request);

        return redirect()->back();
    }

    public function show(Product $product)
    {
        return view('admin.product.edit', [
            'title' => 'Chỉnh Sửa Sản Phẩm',
            'product' => $product,
            'menus' => $this->productService->getMenu()
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $result = $this->productService->update($request, $product);
        if ($result) {
            return redirect('/admin/products/list');
        }

        return redirect()->back();
    }


    public function destroy(Request $request)
    {
        $result = $this->productService->delete($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công sản phẩm'
            ]);
        }

        return response()->json([ 'error' => true ]);
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', '%' . $query . '%')
                           ->get();
        return view('admin.product.search', compact('products', 'query'))->with('title', 'Tìm kiếm');
    }
}
