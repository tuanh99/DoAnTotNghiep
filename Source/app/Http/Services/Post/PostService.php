<?php

namespace App\Http\Services\Post;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
class PostService
{
    public function insert($request)
    {
        try {
            #$request->except('_token');
            Post::create($request->input());
            Session::flash('success', 'Thêm Bài Viết thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Bài Viết LỖI');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function get()
    {
        return Post::orderByDesc('id')->paginate(15);
    }


    public function update($request, $post)
    {
        try {
            $post->fill($request->input());
            $post->save();
            Session::flash('success', 'Cập nhật Bài Viết thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật Bài Viết Lỗi');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function destroy($request)
    {
        $post = Post::where('id', $request->input('id'))->first();
        if ($post) {
            // $path = str_replace('storage', 'public', $post->thumb);
            // Storage::delete($path);
            $post->delete();
            return true;
        }

        return false;
    }

    // public function show()
    // {
    //     return Post::where('active', 1)->orderByDesc('sort_by')->get();
    // }
    public function getAllPosts()
{
    return Post::all();
}
}
