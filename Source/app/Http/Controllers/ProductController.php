<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Product\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index($id = '', $slug = '')
    {
        $product = $this->productService->show($id);
        $productsMore = $this->productService->more($id);

        return view('products.content', [
            'title' => $product->name,
            'product' => $product,
            'products' => $productsMore
        ]);
    }


    //chat

    //  // Danh sách sản phẩm và tìm kiếm
    //  public function list(Request $request)
    //  {
    //      // Lấy từ khóa tìm kiếm từ request
    //      $search = $request->query('search');
 
    //      // Gọi đến phương thức search trong ProductService với từ khóa tìm kiếm
    //      $products = $this->productService->search($search);
 
    //      // Trả về view với danh sách sản phẩm và từ khóa tìm kiếm (nếu có)
    //      return view('products.index', [
    //          'title' => $search ? "Kết quả tìm kiếm cho: $search" : 'Danh Sách Sản Phẩm',
    //          'products' => $products,
    //          'search' => $search
    //      ]);
    //  }
}
