@component('mail::message')
# Chúc mừng, Đơn hàng của bạn đã được tạo thành công!

Xin chào {{ $customer->name }},

Đơn hàng của bạn đã được tạo thành công với các thông tin sau:
- Tên khách hàng: {{ $customer->name }}
- Email: {{ $customer->email }}
- Điện thoại: {{ $customer->phone }}
- Địa chỉ: {{ $customer->address }}
- Ghi chú: {{ $customer->content }}
- Trạng thái đơn hàng: {{ $customer->status }}

@foreach ($orderDetails as $item)
- Tên sản phẩm: {{ $item['product_name'] }}
- Số lượng: {{ $item['quantity'] }}
- Giá: {{ number_format($item['price'], 0, ',', '.') }} VNĐ
@endforeach

Tổng tiền đơn hàng: {{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $orderDetails)), 0, ',', '.') }} VNĐ

Thông báo được gửi từ HealthyShapes
Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
