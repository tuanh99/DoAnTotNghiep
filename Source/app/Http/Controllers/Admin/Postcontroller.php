<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Services\Post\PostAdminService;
class PostController extends Controller
{
    protected $post;

    public function __construct(PostAdminService $post)
    {
        $this->post = $post;
    }
    // public function index()
    // {   
    //         // $products = Product::orderBy('id', 'desc')->paginate(10);
    //         $title = "Danh sách bài viết";
    //         $posts = $this->postService->get();
    //         return view('admin.posts.list', compact('posts'));
    //         // 'posts' => $this->productService->get()
    //         // chat
    //         // 'products'=> $products
    //         // $products = Product::orderBy('id', 'desc')->get()
        
    // }

    public function index()
    {
        return view('admin.posts.list', [
            'title' => 'Danh Sách Bài Viết',
            'post' => $this->post->get()
        ]);
    }
    // Hiển thị form tạo bài viết mới
    public function create()
    {
        $title = "Thêm bài viết mới";
        return view('admin.posts.add', compact('title'));   
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'content'   => 'required'
        ]);

        $this->post->insert($request);

        return redirect()->back();
    }
    public function show(Post $post)
    {
        return view('admin.posts.edit',[
            'title' => 'Chỉnh Sửa Bài Viết',
            'post' => $post

        ]);

    }
    public function update(Request $request, Post $post)
    {
        $this-> validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'content'   => 'required'
        ]);
        $result = $this->post->update($request, $post);
        if ($result) {
            return redirect('/admin/posts/list');
        }

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->post->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công Bài Viết'
            ]);
        }

        return response()->json([ 'error' => true ]);
    }
}
