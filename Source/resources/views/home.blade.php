@extends('main')

@section('content')
    <!-- Slider -->
    <section class="section-slide">
        <div class="wrap-slick1">
            <div class="slick1">
                @foreach($sliders as $slider)

                    <div class="item-slick1" style="background-image: url({{ $slider->thumb }});">
                        <div class="container h-full">
                            <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                                <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                            <span class="ltext-101 cl2 respon2">
                                HOT 2024
                            </span>
                                </div>

                                <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                    <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                        {{ $slider->name }}
                                    </h2>
                                </div>

                                <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                    <a href="{{ $slider->url }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 blink-button">
                                        Mua Ngay
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- <form action="{{ route('user.logout') }}" method="POST">
        @csrf
        <button type="submit">Đăng xuất</button>
    </form> -->
    <!-- Product -->
    <section class="bg0 p-t-23 p-b-140">
        <div class="container">

            <div id="loadProduct">
                @include('products.list')
            </div>

        </div>
    </section>
    <style>
        /* Hiệu ứng nhấp nháy cho nút */
@keyframes blink {
    0% { background-color: #e60000; color: white; }
    50% { background-color: #ff9999; color: black; }
    100% { background-color: #e60000; color: white; }
}

.blink-button {
    animation: blink 1s infinite; /* Thời gian của một vòng lặp animation */
    text-transform: uppercase;
    font-weight: bold;
    border-radius: 50px; /* Làm cho nút có góc bo tròn */
}

    </style>
@endsection
