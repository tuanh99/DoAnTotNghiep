@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th style="width: 50px">Stt</th>
            <th>Tên Sản Phẩm</th>
            <th>Danh Mục</th>
            <th>Giá Gốc</th>
            <th>Giá Khuyến Mãi</th>
            <th>
            <a href="{{ route('products.list', ['sort_by' => 'stock', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}">
        Kho
        @if (request('sort_by') == 'stock')
            @if (request('sort_order') == 'asc')
                <i class="fas fa-sort-amount-up"></i>
            @else
                <i class="fas fa-sort-amount-down"></i>
            @endif
        @endif
    </a>
            </th>
            <th><a href="{{ route('products.list', ['sort_by' => 'total_sold', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}">
        Đã Bán
        @if (request('sort_by') == 'total_sold')
            @if (request('sort_order') == 'asc')
                <i class="fas fa-sort-amount-up"></i>
            @else
                <i class="fas fa-sort-amount-down"></i>
            @endif
        @endif
    </a></th>
            <th>Trạng Thái</th>
            <th><a href="{{ route('products.list', ['sort_by' => 'updated_at', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}">
        Cập Nhật
        @if (request('sort_by') == 'updated_at')
            @if (request('sort_order') == 'asc')
                <i class="fas fa-sort-amount-up"></i>
            @else
                <i class="fas fa-sort-amount-down"></i>
            @endif
        @endif
    </a></th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
            @foreach($products as $key => $product)
            <tr>
                <!-- <td>{{ $product->index }}</td> -->
                <td>{{ $key + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->menu->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->price_sale }}</td>
                <td>{{ $product->stock }}</td>
                
                <td>{{ $product->total_sold ?? 0}}</td>
                <td>{!! \App\Helpers\Helper::active($product->active) !!}</td>
                <td>{{ $product->updated_atformat }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="/admin/products/edit/{{ $product->id }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow({{ $product->id }}, '/admin/products/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $products->links() !!}
    </div>
@endsection


