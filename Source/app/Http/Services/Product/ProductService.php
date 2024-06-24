<?php


namespace App\Http\Services\Product;


use App\Models\Product;

class ProductService
{
    const LIMIT = 16;

    public function get($page = null)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->orderByDesc('id')
            ->when($page != null, function ($query) use ($page) {
                $query->offset($page * self::LIMIT);
            })
            ->limit(self::LIMIT)
            ->get();
    }

    public function show($id)
    {
        return Product::where('id', $id)
            ->where('active', 1)
            ->with('menu')
            ->firstOrFail();
    }

    public function more($id)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->where('id', '!=', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
    }


    //  chat
    // Phương thức tìm kiếm sản phẩm
    // public function search($search = null)
    // {
    //     return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
    //         ->when($search, function ($query) use ($search) {
    //             $query->where('name', 'like', '%' . $search . '%')
    //                   ->orWhere('description', 'like', '%' . $search . '%');
    //         })
    //         ->orderByDesc('id')
    //         ->paginate(self::LIMIT); // Sử dụng phân trang cho kết quả tìm kiếm
    // }
}
