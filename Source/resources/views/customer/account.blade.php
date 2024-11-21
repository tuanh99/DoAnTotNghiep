@extends('main')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-6 col-lg-4">

        <div style = "margin: 120px 0 50px 0; box-shadow: 0 0 10px rgba(0,0,0,0.3);"class="card">
            <div class="card-header text-center">
                <h3>Thông tin cá nhân</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên tài khoản</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" required>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif
    
                    <button type="submit" class="btn btn-primary w-100">Cập Nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
