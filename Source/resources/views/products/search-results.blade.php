@extends('main')

@section('content')
<div class="container p-t-80" >
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="/" class="stext-109 cl8 hov-cl1 trans-04">
            Trang chủ
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>
        <span class="stext-109 cl4">
            Tìm kiếm: {{ $query }}
            
        </span>
    </div>
</div>

<div class="container">
    <div style="margin-bottom: 100px"  class="row isotope-grid">
        @if ($products->isEmpty())
            <div   class="col-12 p-t-30">
                <p class="text-center">Không có kết quả tìm kiếm cho "{{ $query }}"</p>
    
            </div>
        @else
        @foreach($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="{{ $product->thumb }}" alt="{{ $product->name }}">
                    </div>
                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l ">
                            <a href="/san-pham/{{ $product->id }}-{{ Str::slug($product->name, '-') }}.html"
                               class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                {{ $product->name }}
                            </a>
                            <span class="stext-105 cl3">
                                {!! \App\Helpers\Helper::price($product->price, $product->price_sale) !!}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>
</div>
@endsection
