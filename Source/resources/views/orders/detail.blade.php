@extends('main')

@section('content')
<div style =" " class="center container mt-5">
    <!-- <h2  class="text-center text-success my-4">Chi Tiết Đơn Hàng #{{ $order->id }}</h2> -->
    <div style ="border: 1px #000 solid;margin-top: 120px" class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-success mb-4 font-weight-bold text-uppercase">Thông tin người nhận</h3>
                    <ul class="list-unstyled">
                        <li><strong>Tên khách hàng:</strong> {{ $order->customer_name }}</li>
                        <li><strong>Số điện thoại:</strong> {{ $order->phone }}</li>
                        <li><strong>Địa chỉ:</strong> {{ $order->address }}</li>
                        <li><strong>Email:</strong> {{ $order->email }}</li>
                        @if (!empty($order->content))
                            <li><strong>Ghi chú:</strong> {{ $order->content }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-success mb-4 font-weight-bold text-uppercase">Thông tin đơn hàng</h3>
                    <ul class="list-unstyled">
                        <li><strong>Mã đơn hàng: </strong>{{$order->id}}</li>
                        <li><strong>Trạng thái:</strong> <span class="text-danger font-weight-bold">{{ $order->status }}</span></li>
                        <li><strong>Ngày đặt hàng:</strong> {{ $order->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}</li>
                        @if($order->updated_at)
                            <li><strong>Ngày cập nhật trạng thái:</strong> {{ $order->updated_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <h3 class="text-center text-success mb-4">Danh sách sản phẩm trong đơn hàng</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $key => $orderDetail)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $orderDetail->product_name }}</td>
                        <td>{{ $orderDetail->product_quantity }}</td>
                        <td>{{ number_format($orderDetail->product_price, 0, ',', '.') }} VNĐ</td>
                        <td>{{ number_format($orderDetail->product_price * $orderDetail->product_quantity, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                    <th colspan="4" class="text-right">Tổng tiền:</th>
                        <th class="text-danger font-weight-bold">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection