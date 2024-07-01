@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th style="width: 50px">Stt</th>
            <th>Tên Khách Hàng</th>
            <th>Số Điện Thoại</th>
            <th>Email</th>
            <th>Ngày Đặt hàng</th>
            <th>Trạng Thái</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customers as $key => $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}</td>
                <td>
                    <form action="{{ route('customers.update-status', ['customer' => $customer->id]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <select class="form-control" name="status" onchange="this.form.submit()">
                            <option value="Đang chuẩn bị" {{ $customer->status == 'Đang chuẩn bị' ? 'selected' : '' }}>Đang chuẩn bị</option>
                            <option value="Đang giao hàng" {{ $customer->status == 'Đang giao hàng' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="Đã giao thành công" {{ $customer->status == 'Đã giao thành công' ? 'selected' : '' }}>Đã giao thành công</option>
                            <option value="Đã hủy" {{ $customer->status == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </form>

                </td>
                <td>

                
                    <a class="btn btn-primary btn-sm" href="/admin/customers/view/{{ $customer->id }}">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow({{ $customer->id }}, '/admin/customers/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            
        @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $customers->links() !!}
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
