<?php

namespace App\Http\Services\Post;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
class PostService
{
   
    public function get()
    {
        // return Post::orderByDesc('id');
        return Post::select('id', 'name', 'content','thumb')
            ->orderByDesc('id');
    }
    
    public function getAllPosts()
{
    return Post::all();
}

public function show($id)
{
    return Post::where('id', $id)
        ->where('active', 1)
        ->with('menu')
        ->firstOrFail();
}


//     public function show($id, $slug)
// {
//     try {
//         // Tìm bài viết với ID cụ thể
//         $posts = Post::findOrFail($id);

//         // Trả về view với dữ liệu bài viết
//         return view('posts.content', [
//             'title' => $posts->name,
//             'posts' => $posts
//         ]);
//     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//         // Nếu không tìm thấy bài viết, trả về lỗi 404
//         abort(404);
//     }
// }

}
