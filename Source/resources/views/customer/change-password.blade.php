@extends('main')

@section('content')
<div  class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div style="margin: 100px 0 50px 0" class="card">
                <div class="card-header text-center">{{ __('Đổi mật khẩu') }}</div>

                <div class="card-body">

                    <form action="{{ route('user.change-password.update', ['id' => $user->id]) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="current_password">Mật khẩu hiện tại:</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="new_password">Mật khẩu mới:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">Nhập lại mật khẩu mới:</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                        </div>
                        @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        <button type="submit" class="btn btn-primary w-100">Đổi mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection