<?php
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
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.list', [
            'title' => 'Bài Viết',
            'posts' => $posts,
        ]);
    }

    public function show($id)
{
    try {
        // Tìm bài viết với ID cụ thể
        $posts = Post::findOrFail($id);

        // Trả về view với dữ liệu bài viết
        return view('posts.content', [
            'title' => $posts->name,
            'posts' => $posts
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Nếu không tìm thấy bài viết, trả về lỗi 404
        abort(404);
    }
}
}
