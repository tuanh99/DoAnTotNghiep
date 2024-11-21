

@extends('main')

@section('content')
<div class="container mt-5">
    <h2 class="text-center" style="margin-top: 110px">Đơn hàng của tôi</h2>
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if($orders->isEmpty())
        <p class="text-center mt-5">Bạn chưa có đơn hàng nào.</p>
    @else
        <table class="table table-bordered table-hover mt-5">
            <thead class="thead-dark">
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>SĐT</th>
                    <th>Địa chỉ</th>
                    <th>Email</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Hành động</th>
                    <th>Ngày đặt đơn</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->note }}</td>
                        <td>
                            @if(!in_array($order->status, ['Đang giao hàng', 'Đã giao thành công', 'Hủy']))
                                <form action="{{ route('order.update.status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                        <option value="{{ $order->status }}">{{ $order->status }}</option>
                                        <option value="Hủy">Hủy</option>
                                    </select>
                                </form>
                            @else
                                <span class="badge badge-{{ $order->status == 'Hủy' ? 'danger' : ($order->status == 'Đang giao hàng' ? 'warning' : 'success') }}">
                                    {{ $order->status }}
                                </span>
                            @endif
                        </td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                        <td><a href="{{ route('order.detail', ['order_id' => $order->id]) }}" class="btn btn-sm btn-info">Xem Chi Tiết</a></td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
