@extends('admin.main')

@section('content')
<div class="container">

<div class="row mb-3">
    <div class="col-12 col-md-6 d-flex align-items-center">
        <h2 class="mb-0">Sản phẩm</h2>
    </div>
    <div class="col-12 col-md-6 d-flex justify-content-end">
        <form action="{{ route('products.search') }}" method="GET" class="d-flex mb-0">
            <div class="input-group">
                <input type="text" name="query" class="form-control" style="width:auto;" placeholder="Nhập từ khóa tìm kiếm">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>
</div>




    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th style="width: 50px">STT</th>
            <th>Tên Sản Phẩm</th>
            <th>Danh Mục</th>
            <th>Giá Gốc</th>
            <th>Giá Khuyến Mãi</th>
            <th>Số lượng</th>
            <th>Active</th>
            <th>Update</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
            @foreach($products as $key => $product)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->menu->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->price_sale }}</td>
                <td>{{ $product->stock }}</td>
                <td>{!! \App\Helpers\Helper::active($product->active) !!}</td>
                <td>{{ $product->updated_at }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="/admin/products/edit/{{ $product->product_id }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow({{ $product->product_id }}, '/admin/products/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        
    </div>
</div>
@endsection