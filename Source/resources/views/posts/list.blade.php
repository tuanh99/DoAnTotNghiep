@extends('main')
@section('content')
<div class="row isotope-grid">
    <!-- <p>-	Bài viết hướng dẫn về thể dục, chế độ ăn uống: Cung cấp các bài viết, hướng dẫn và tài liệu hữu ích về tập luyện, chăm sóc sức khỏe, chế độ ăn uống phù hợp với mục tiêu tập luyện của người dùng</p> -->
    @foreach($post as $key => $post)
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
            <!-- Block2 -->
            <div class="block2">
                <div class="block2-pic hov-img0">
                <img src="{{ $post->thumb }}" alt="{{ $post->name }}">
                </div>

                <div class="block2-txt flex-w flex-t p-t-14">
                    <div class="block2-txt-child1 flex-col-l ">
                        <a href="{{ route('post.show', ['id' => $post->id, 'slug' => Str::slug($post->name, '-')]) }}"
                           class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                            {{ $post->name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection