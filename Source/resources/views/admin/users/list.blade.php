@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')

<div class="container">
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Tên Tài Khoản</th>
                <th>Email</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th style="width: 100px;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $user->updated_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}</td>
                    <td>
                        @if($user->status == 1)
                            <a href="#" class="btn btn-danger btn-sm" title="Vô hiệu hóa tài khoản"
                               onclick="removeRow({{ $user->id }}, '/admin/users/deactivate')">
                                <i class="fas fa-trash"></i>
                            </a>
                        @else
                            <a href="#" class="btn btn-success btn-sm" title="Kích hoạt tài khoản"
                               onclick="activateRow({{ $user->id }}, '/admin/users/activate')">
                                <i class="fas fa-check"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');

        function removeRow(id, url) {
            if (confirm('Bạn có chắc muốn vô hiệu hóa tài khoản này?')) {
                $.post(url + '/' + id, {_method: 'POST', _token: '{{ csrf_token() }}'}, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi vô hiệu hóa tài khoản.');
                    }
                });
            }
        }

        function activateRow(id, url) {
            if (confirm('Bạn có chắc muốn kích hoạt tài khoản này?')) {
                $.post(url + '/' + id, {_method: 'POST', _token: '{{ csrf_token() }}'}, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi kích hoạt tài khoản.');
                    }
                });
            }
        }
    </script>
@endsection
