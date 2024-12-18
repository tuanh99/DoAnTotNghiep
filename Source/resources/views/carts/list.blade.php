@extends('main')

@section('content')
    <form class="bg0 p-t-130 p-b-85" method="post" id="orderForm">
        @include('admin.alert')

        @if (count($products) != 0)
            <div class="container">
                <div class="row">
                    <!-- Phần giỏ hàng -->
                    <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                @php $total = 0; @endphp
                                <table class="table-shopping-cart">
                                    <tbody>
                                    <tr class="table_head">
                                        <th class="column-1">Sản phẩm</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">Giá</th>
                                        <th class="column-4">Số lượng</th>
                                        <th class="column-5">Tổng</th>
                                        <th class="column-6">&nbsp;</th>
                                    </tr>

                                    @foreach($products as $key => $product)
                                        @php
                                            $price = $product->price_sale != 0 ? $product->price_sale : $product->price;
                                            $priceEnd = $price * $carts[$product->id];
                                            $total += $priceEnd;
                                        @endphp
                                        <tr class="table_row">
                                            <td class="column-1">
                                                <div class="how-itemcart1">
                                                    <img src="{{ $product->thumb }}" alt="IMG">
                                                </div>
                                            </td>
                                            <td class="column-2">{{ $product->name }}</td>
                                            <td class="column-3">{{ number_format($price, 0, '', '.') }}</td>
                                            <td class="column-4">
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </div>

                                                    <!-- <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                    name="num_product[{{ $product->id }}]" value="{{ $carts[$product->id] }}"
                                                    min="1" max="{{ $product->stock }}" required> -->

                                                 
    <input class="mtext-104 cl3 txt-center num-product" type="number"
           name="num_product[{{ $product->id }}]" value="{{ $carts[$product->id] }}"
           min="1" max="{{ $product->stock }}" data-product-name="{{ $product->name }}" required>

                                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="column-5">{{ number_format($priceEnd, 0, '', '.') }}</td>
                                            <td class="p-r-15">
                                                <a href="/carts/delete/{{ $product->id }}">Xóa</a>
                                            </td>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                                <input type="submit" value="Cập nhật giỏ hàng" formaction="/update-cart"
                                    class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                @csrf
                            </div>
                        </div>
                    </div>

                    <!-- Phần thông tin khách hàng -->
                    <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            <h4 class="mtext-109 cl2 p-b-30">
                                Tổng thanh toán
                            </h4>

                            <div class="flex-w flex-t p-t-27 p-b-33">
                                <div class="size-208">
                                    <span class="mtext-101 cl2">
                                        Tổng:
                                    </span>
                                </div>

                                <div class="size-209 p-t-1">
                                    <span class="mtext-110 cl2">
                                        {{ number_format($total, 0, '', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex-w flex-t bor12 p-t-15 p-b-30">

                                <div class="size-100 p-r-18 p-r-0-sm w-full-ssm">

                                    <div class="p-t-15">
                                        <span class="stext-112 cl8">
                                            Thông Tin Khách Hàng
                                        </span>

                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="name" placeholder="Tên khách Hàng" value="{{ old('name') }}" required>
                                        </div>

                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="phone" placeholder="Số Điện Thoại" value="{{ old('phone') }}" required>
                                        </div>

                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="address" placeholder="Địa Chỉ Giao Hàng" value="{{ old('address') }}">
                                        </div>

                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="email" placeholder="Email Liên Hệ" value="{{ old('email') }}">
                                        </div>

                                        <div class="bor8 bg0 m-b-12">
                                            <textarea class="cl8 plh3 size-111 p-lr-15" name="content">{{ old('content') }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- <button  class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                               Đặt Hàng
                            </button> -->
                            <input type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer m-tb-10" value="Đặt hàng">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="text-center" style="margin-bottom: 50px"><h2>Giỏ hàng trống</h2></div>
    @endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tìm form đặt hàng
        let orderForm = document.getElementById('order-form');

        orderForm.addEventListener('submit', function(event) {
            // Duyệt qua tất cả các input số lượng
            let quantityInputs = document.querySelectorAll('.num-product');
            let hasError = false;
            let errorMessages = [];

            quantityInputs.forEach(function(input) {
                let max = parseInt(input.getAttribute('max'));
                let value = parseInt(input.value);

                if (value > max) {
                    hasError = true;
                    let productName = input.getAttribute('data-product-name'); // Lấy tên sản phẩm từ thuộc tính data
                    errorMessages.push('Số lượng sản phẩm "' + productName + '" vượt quá số lượng tồn kho. Tối đa là ' + max);
                }
            });

            if (hasError) {
                // Ngăn chặn form gửi đi
                event.preventDefault();
                alert(errorMessages.join('\n')); // Hiển thị tất cả lỗi trong alert
            }
        });
    });
</script>


@endsection