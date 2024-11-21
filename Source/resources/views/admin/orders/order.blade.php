@extends('admin.main')

@section('content')
@php
use App\Models\Customer;
$customers = Customer::All();
@endphp
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th style="width: 70px">Mã ĐH</th>
            <th>Mã Tài Khoản</th>
            <th>Tên Khách Hàng</th>
            <th>Số Điện Thoại</th>
            <th>Email</th>
            <th>Thời Gian Đặt Hàng</th>
            <!-- <th>Thời Gian Cập Nhật</th> -->
            <th>Tổng Đơn Hàng</th>
            <th>Trạng Thái</th>
            <th style="width: 70px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{$order->user_id}}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->created_at }}</td>
                <!-- <td>{{ $order->updated_at }}</td> -->
                <td>{{ number_format($order->total_amount, 0, '', '.')}}</td>
                <td >
                    <form action="{{ route('orders.update-status', ['order' => $order->id]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <select class="form-control" name="status" onchange="this.form.submit()" {{ in_array($order->status, ['Đã giao thành công', 'Hủy']) ? 'disabled' : '' }}>
                            <option value="Đang chuẩn bị" {{ $order->status == 'Đang chuẩn bị' ? 'selected' : '' }}>Đang chuẩn bị</option>
                            <option value="Đang giao hàng" {{ $order->status == 'Đang giao hàng' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="Đã giao thành công" {{ $order->status == 'Đã giao thành công' ? 'selected' : '' }}>Đã giao thành công</option>
                            <option value="Hủy" {{ $order->status == 'Hủy' ? 'selected' : '' }}>Hủy</option>
                        </select>
                    </form>

                </td>
                

                <td><a href="{{ route('admin.order.detail', ['order_id' => $order->id]) }}" class="btn btn-sm btn-info">Xem Chi Tiết</a></td>
                    
                    
                
            </tr>
            
        @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $orders->links() !!}
    </div>



@endsection

@section('scripts')
    <script>
        function updateStatus(status, customerId) {
            axios.post(`/admin/customers/update-status/${customerId}`, {
                _token: '{{ csrf_token() }}',
                status: status
            })
            .then(function(response) {
                alert('Cập nhật trạng thái thành công');
                // Cập nhật giao diện nếu cần
            })
            .catch(function(error) {
                alert('Có lỗi xảy ra khi cập nhật trạng thái');
                console.error(error);
            });
        }
    </script>
@endsection
