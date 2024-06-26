<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Services\Blog\BlogService;

class BlogController extends Controller
{
    protected $blog;

    public function __construct(BlogService $blog)
    {
        $this->blog = $blog;
    }

    public function create()
    {
        return view('admin.blog.add', [
           'title' => 'Thêm blog mới'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $this->blog->insert($request);

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.blog.list', [
            'title' => 'Danh Sách blog Mới Nhất',
            'blogs' => $this->blog->get()
        ]);
    }

    public function show(blog $blog)
    {
        return view('admin.blog.edit', [
            'title' => 'Chỉnh Sửa blog',
            'blog' => $blog
        ]);
    }

    public function update(Request $request, blog $blog)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $result = $this->blog->update($request, $blog);
        if ($result) {
            return redirect('/admin/blogs/list');
        }

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->blog->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công blog'
            ]);
        }

        return response()->json([ 'error' => true ]);
    }
}
