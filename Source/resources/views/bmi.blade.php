@extends('main')
@section('content')

<!-- Phần nội dung tính BMI -->
<div class="bmi-container">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-4 pt-5">TÍNH BMI (CHỈ SỐ KHỐI CƠ THỂ)</h1>
                <p class="mb-4">Đo chỉ số BMI tại HealthyShapes để đánh giá mức độ béo, gầy hay cân nặng lý tưởng của bạn. HealthyShapes hỗ trợ hội viên đo chỉ số BMI trước và trong quá trình tập luyện để hội viên có thể theo dõi được kết quả tập luyện. BMI là chỉ số khối cơ thể (Body Mass Index), được các bác sĩ và chuyên gia sức khỏe dùng để xác định một người có bị béo phì, thừa cân hay quá gầy.</p>
                <form id="bmiForm" class="card p-4 shadow">
                    <div class="form-group">
                        <label for="height">Chiều Cao (cm):</label>
                        <input type="number" class="form-control" id="height" name="height" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="weight">Cân Nặng (kg):</label>
                        <input type="number" class="form-control" id="weight" name="weight" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Tính BMI</button>
                </form>
                <div id="result" class="mt-4"></div>
            </div>
            <div class="col-md-6">
                <img src="https://thethaodonga.com/wp-content/uploads/2022/01/anh-gym-nghe-thuat-30.jpg" alt="Ảnh gym" class="img-fluid" style="height: 100%;">
            </div>
        </div>
    </div>
</div>

<style>
    /* Đảm bảo body có margin và padding bằng 0 */
    body {
        margin: 0;
        padding: 0;
        background-color: #f4f4f9; /* Màu nền nhẹ nhàng */
    }

    /* Đảm bảo container BMI full chiều ngang */
    .bmi-container {
        width: 100%;
        position: relative;
        padding: 50px 0; 
        
    }

    /* Lớp phủ màu đen nhạt */
    .bmi-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5); /* Màu đen với độ trong suốt 50% */
        z-index: 0;
    }

    /* Đảm bảo nội dung trên lớp phủ */
    .bmi-container > .container {
        position: relative;
        z-index: 1;
        color: #fff; /* Màu trắng để chữ nổi bật */
    }

    h1 {
        color: #333; /* Màu xanh đẹp */
    }

    .form-group label {
        color: #000; /* Màu trắng cho nhãn */
    }

    input {
        background-color: rgba(255, 255, 255, 0.7); /* Nền trắng với độ trong suốt nhẹ */
        color: #000; /* Màu chữ đen */
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    input::placeholder {
        color: #666; /* Màu placeholder nhẹ */
    }

    button {
        padding: 10px 20px;
        border: none;
        background-color: #5cb85c;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #4cae4c;
    }

    #result {
        margin-top: 20px;
        font-size: 18px;
        color: #fff; /* Màu trắng cho kết quả */
    }
</style>

<script>
    document.getElementById('bmiForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Lấy giá trị từ các trường nhập liệu
        let height = parseFloat(document.getElementById('height').value);
        let weight = parseFloat(document.getElementById('weight').value);

        // Chuyển đổi chiều cao từ cm sang mét
        height = height / 100;

        // Tính BMI
        let bmi = weight / (height * height);

        // Làm tròn BMI đến 2 chữ số thập phân
        bmi = bmi.toFixed(2);

        // Hiển thị kết quả
        let result = document.getElementById('result');
        result.innerHTML = `Chỉ số BMI của bạn là: ${bmi}`;

        // Đưa ra đánh giá về BMI
        if (bmi < 18.5) {
            result.innerHTML += "<br>Bạn đang dưới cân.";
        } else if (bmi >= 18.5 && bmi < 24.9) {
            result.innerHTML += "<br>Bạn có cân nặng bình thường.";
        } else if (bmi >= 25 && bmi < 29.9) {
            result.innerHTML += "<br>Bạn đang thừa cân.";
        } else {
            result.innerHTML += "<br>Bạn đang béo phì.";
        }
    });
</script>

@endsection
