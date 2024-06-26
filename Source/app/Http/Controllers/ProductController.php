<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Product\ProductService;
use App\Models\Product;
use Illuminate\Support\Str;
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

    public function search(Request $request)
    {
        $query = $request->input('search');
        $products = $this->productService->search($query);
    
        return view('products.search-results', [
            'title' => "Kết quả tìm kiếm cho: $query",
            'products' => $products,
            'query' => $query
        ]);

    }
}
