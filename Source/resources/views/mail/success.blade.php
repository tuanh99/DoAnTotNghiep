@component('mail::message')
# Chúc mừng, Đơn hàng của bạn đã được tạo thành công!

Xin chào {{ $order->customer_name }},

Đơn hàng của bạn đã được tạo thành công với các thông tin sau:
- Tên khách hàng: {{ $order->customer_name }}
- Email: {{ $order->customer_email }}
- Điện thoại: {{ $order->customer_phone }}
- Địa chỉ: {{ $order->customer_address }}
- Ghi chú: {{ $order->note }}

Tổng tiền đơn hàng: {{ number_format($order->total, 0, ',', '.') }} VNĐ

Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
