@extends('admin.main')

@section('content')
   



<!-- Hiển thị top  sản phẩm bán chạy -->
<div class="top-selling-products ">
        <h2 style=" text-align: center;font-weight: 550; font-size: 25px">Top 5 Sản phẩm bán chạy trong tháng</h2>
        <table style="width: 100%" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr> 
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th style = "width: 100px">Đã bán</th>
                    <th>Tháng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topSellingProducts as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style=" text-align: start;">{{ $product->product_name }}</td>
                        <td>{{ $product->menu_name }}
                        <td>{{ $product->total_sold }}</td>
                        <td>{{ $product->month }}/{{ $product->year }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container">
    <div class='col'></div>
        <div class="row order-today">
            <h2 style="text-align: center; font-weight: 550; font-size: 25px">Đơn hàng giao thành công trong ngày</h2>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên KH</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Tổng số tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ordersToday as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td style=" text-align: start;">{{ $order->email }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="total-revenue" style="text-align: center;">
                <h3>Tổng doanh thu trong ngày: {{ number_format($totalRevenue, 0, ',', '.') }} đ</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2 style="text-align: center; font-weight: 550; font-size: 25px" >Doanh thu từng ngày</h2>
                @if ($dailyRevenues->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Ngày</th>
                                <th>Doanh thu</th>
                                <th>Số hóa đơn</th>
                                <th>Lợi nhuận</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dailyRevenues as $dailyRevenues)
                                <tr>
                                    <td>{{ $dailyRevenues->date }}</td>
                                    <td>{{ number_format($dailyRevenues->total_revenue, 0, ',', '.') }} VND</td>
                                    <td>{{ $dailyRevenues->total_orders }}</td>
                                    <td>{{ number_format($dailyProfits[$dailyRevenues->date], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                    <tr>
                    <th colspan="1" class="text-right">Tổng</th>
                        <th class="text-danger font-weight-bold">{{ number_format($totalRevenueThisMonth, 0, ',', '.') }} VNĐ</th>
                        <th class="text-danger font-weight-bold">{{ number_format($totalOrdersThisMonth, 0, ',', '.') }}</th>
                        <th class="text-danger font-weight-bold">{{ number_format(array_sum($dailyProfits), 0, ',', '.') }} VNĐ</th>
                    </tr>
                    
                </tfoot>
                    </table>
                    <!-- <div class="total-revenueThisMonth" style="text-align: center; width: 500px">
                        <h3  >Tổng doanh thu trong tháng: {{ number_format($totalRevenueThisMonth, 0, ',', '.') }} </h3>
                    </div> -->
                @else
                    <p>Không có dữ liệu doanh thu.</p>
                @endif

                

        </div>
    </div>
</div>



<style>
    .container{
        display: flex;
        /* flex-wrap: wrap; */
        justify-content : space-around;
      
    }
.table{
    /* height: 900px; */
    background-color: #fff;
    width: 35vw;
    text-align: center;
    border-radius: 10px; /* Bo góc cho thẻ */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng */
   
}
    /* Đặt CSS cho toàn bộ thẻ dashboard */
.dashboard-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Khoảng cách giữa các thẻ */
    padding: 20px;
    /* background-color: #f9f9f9; Màu nền cho khu vực hiển thị */
    border-radius: 10px; /* Bo góc cho khu vực hiển thị */
    justify-content: center; /* Canh giữa các thẻ trên các màn hình lớn */
}

/* Đặt CSS cho từng thẻ */
.card {
    display: flex;
    align-items: center;
    text-align: center;
    background-color: #ffffff; /* Màu nền cho từng thẻ */
    border-radius: 10px; /* Bo góc cho thẻ */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng */
    padding: 20px;
    width: 250px; /* Độ rộng của thẻ */
    transition: transform 0.3s, box-shadow 0.3s; /* Hiệu ứng khi hover */
    flex: 1; /* Để các thẻ có cùng kích thước */
    max-width: calc(33.333% - 20px); /* Tính toán để giữ khoảng cách */
    box-sizing: border-box; /* Đảm bảo padding không ảnh hưởng đến độ rộng */
}

/* CSS cho biểu tượng trong thẻ */
.card-icon {
    font-size: 40px; /* Kích thước của biểu tượng */
    margin-right: 15px;
    color: #007bff; /* Màu sắc của biểu tượng */
}

/* CSS cho nội dung của thẻ */
.card-content h2 {
    margin: 0;
    font-size: 18px; /* Kích thước chữ cho tiêu đề */
    color: #333; /* Màu chữ cho tiêu đề */
}
.card-content p {
    margin: 5px 0 0;
    font-size: 24px; /* Kích thước chữ cho số liệu */
    font-weight: bold;
    color: #555; /* Màu chữ cho số liệu */
}

/* Hiệu ứng khi hover */
.card:hover {
    transform: translateY(-5px); /* Di chuyển lên trên khi hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Tăng độ đổ bóng khi hover */
}

/* Media Queries để điều chỉnh trên các kích thước màn hình khác nhau */
@media (max-width: 1200px) {
    .card {
        max-width: calc(50% - 20px); /* 2 thẻ mỗi hàng trên màn hình vừa */
    }
}

@media (max-width: 768px) {
    .card {
        max-width: 100%; /* 1 thẻ mỗi hàng trên màn hình nhỏ */
    }
}

</style>

@endsection
