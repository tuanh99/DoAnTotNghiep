<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class PostController extends Controller
// {
//     public function index()
//     {
//        return view('post',[
//         'title' => 'Bài Viết Về Tập Luyện'
//        ]);
//     }

// }




namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Post\PostService;
use App\Models\Post;
use Illuminate\Support\Str;
class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index($id = '', $slug = '')
    {
        $post = $this->postService->getAllPosts($id);
        $posts = Post::orderBy('created_at', 'desc')->get(); 
        return view('posts.list',compact('post'), [
            'title' => 'Bài Viết',
            'post' => $post,
        ]);
    }
    public function show($id, $slug)
{
    try {
        $post = $this->postService->get($id);
        return view('posts.content', [
            'title' => 'Chi tiết bài viết',
            'post' => $post,
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        abort(404); // Xử lý khi không tìm thấy bài viết, có thể chuyển hướng hoặc hiển thị lỗi 404
    }
}
}
