@extends('admin.main')

@section('content')
    Trang quản trị Admin
    <div class="dashboard-cards">
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-users"></i> <!-- Icon cho Total Customer -->
        </div>
        <div class="card-content">
            <h2 >Tổng khách hàng</h2>
            <p>{{ $totalCustomers }}</p>
            <h2>Tính đến thời điểm hiện tại</h2>
        </div>
    </div>
    
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-shopping-cart"></i> <!-- Icon cho Total Order -->
        </div>
        <div class="card-content">
            <h2>Tổng đơn hàng</h2>
            <p>{{ $totalOrders }}</p>
            <h2>Tính đến thời điểm hiện tại</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fas fa-dollar-sign"></i> <!-- Icon cho Total Sale -->
        </div>
        <div class="card-content">
            <h2>Tổng doanh thu</h2>
            <p>{{ number_format($totalSalesCompleted, '0', '', '.') }}</p>

            <h2>Tính đến thời điểm hiện tại</h2>
        </div>
    </div>
</div>


<div class="container">
    <div class= "recent-order">
        <h2 style="text-align: center; font-weight: 550; font-size: 25px">Đơn hàng gần đây</h2>
        <table class="table" style="width= 42vw">
            <thead>
                <tr>
                    
                    <th>Ngày đặt hàng</th>
                    <th>Tên khách hàng</th>
                    <th>SĐT</th>
                    <!-- <th>Tổng</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Hiển thị top 10 sản phẩm bán chạy -->
    <div class="top-selling-products">
        <h2 style="text-align: center; font-weight: 550; font-size: 25px">Top 5 Sản phẩm bán chạy</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th style = "width: 100px">Đã bán</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topSellingProducts as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->menu_name }}
                        <td>{{ $product->total_sold }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
