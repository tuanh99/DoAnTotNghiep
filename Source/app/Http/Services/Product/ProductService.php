<?php


namespace App\Http\Services\Product;
use Illuminate\Support\Facades\DB;

use App\Models\Product;

class ProductService
{
    const LIMIT = 100;

    public function get($page = null, $sortBy = 'id', $sortOrder = 'asc')
    {
        return Product::select('id', 'name', 'price_cost', 'price', 'price_sale', 'thumb')
            ->orderBy($sortBy, $sortOrder)
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
            ->orderBy('id')
            ->limit(8)
            ->get();
    }
    // public function search($query)
// {
//     return Product::where('name', 'like', "{$query}%")
//                 //   ->orWherse('description', 'like', "%{$query}%")
//                   ->get();
// }
// }

// public function search($query)
// {
//     // Tách từ khóa thành các từ riêng biệt
//     $keywords = explode(' ', $query);

//     return Product::where(function ($queryBuilder) use ($keywords) {
//         foreach ($keywords as $keyword) {
//             $queryBuilder->where('name', 'like', "%{$keyword}%");
                         
//         }
//     })->get();
// }


public function search($query)
{
    // Thay thế khoảng trắng trong từ khóa bằng %
    // $keyword = str_replace(' ', '%', $query);

    // return Product::where('name', 'like', "%{$keyword}%")
    //               ->get();
                //   return Product::whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$keyword])
                //   ->get();

                $keyword = $query;

                return Product::whereRaw("LOCATE(?, name) > 0", [$keyword])
                              ->get();
}

}