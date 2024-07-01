@extends('main')
@section('content')

<div class="container p-t-80">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="/" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
        <a href="{{ route('post') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Bài viết
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
				{{ $title }}
			</span>
        </div>
    </div>
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
<div class="tab-pane fade show active" id="description" role="tabpanel">
    <div class="how-pos2 p-lr-15-md">
        <p class="stext-102 cl6 txt-center" >
        {!! $posts->name !!}
        </p>
        <!-- <p><img src="{!! $posts->thumb !!}" alt=""></p> -->
        <p>{!! $posts->content !!}</p>
    </div>
</div>

</section>
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Các sản phẩm khác

                    
                </h3>
            </div>
        </div>


@endsection
