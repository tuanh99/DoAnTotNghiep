@extends('admin.main')

@section('content')
<!-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif -->
    <table class="table">
        <thead>
        <tr>
            <th style="width: 50px">Stt</th>
            <th>Tên Bài Viết</th>
            <th>Ảnh</th>
            <th>Cập Nhật</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
            @foreach($post as $key => $post)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $post->name }}</td>
                <td><a href="{{ $post->thumb }}" target="_blank">
                        <img src="{{ $post->thumb }}" height="40px">
                    </a>
                </td>
                <!-- <td>{{ $post->content }}</td> -->
                <td>{{ $post->updated_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')  }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="/admin/posts/edit/{{ $post->id }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow({{ $post->id }}, '/admin/posts/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
        
@endsection


