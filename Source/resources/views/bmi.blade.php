@extends('main')
@section('content')

<!-- Phần nội dung tính BMI -->
<div class="bmi-container">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-4 pt-5">TÍNH BMI (CHỈ SỐ KHỐI CƠ THỂ)</h1>
                <!-- <p class="mb-4">Đo chỉ số BMI tại HealthyShapes để đánh giá mức độ béo, gầy hay cân nặng lý tưởng của bạn. HealthyShapes hỗ trợ hội viên đo chỉ số BMI trước và trong quá trình tập luyện để hội viên có thể theo dõi được kết quả tập luyện. BMI là chỉ số khối cơ thể (Body Mass Index), được các bác sĩ và chuyên gia sức khỏe dùng để xác định một người có bị béo phì, thừa cân hay quá gầy.</p> -->
                <p class="mb-4">BMI là gì?
BMI là viết tắt của "Body Mass Index" (Chỉ số khối cơ thể), đây là một phép đo tiêu chuẩn được sử dụng để đánh giá mức độ cân đối giữa cân nặng và chiều cao của một người. Chỉ số BMI giúp bạn phân loại tình trạng sức khỏe của mình là mập, bình thường, thiếu cân hay ốm. Kết quả tính BMI online giúp bạn biết được cơ thể đang ở tình trạng nào từ đó điều chỉnh để khoẻ mạnh hơn.
BMI được tính bằng công thức sau đây: BMI = Cân nặng/Chiều cao^2
- Cân nặng tính theo kg
- Chiều cao tính theo m</p>
                <p class="mb-4">*Lưu ý:
Công thức BMI được áp dụng cho cả nam và nữ, áp dụng cho người trưởng thành (trên 18 tuổi).
Không áp dụng cho phụ nữ mang thai, vận động viên, người già và có sự thay đổi giữa các quốc gia.</p>
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
                <img src="./template/images/img-product/bmi.jpg" alt="Ảnh gym" class="img-fluid" style="height: 100%;">
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
            result.innerHTML += "<br>Bạn đang gặp phải tình trạng thiếu cân, vì thế nên áp dụng các phương pháp ăn uống và luyện tập để tăng trọng lượng cơ thể.";
        } else if (bmi >= 18.5 && bmi < 22.9) {
            result.innerHTML += "<br>Bạn có cân nặng bình thường.";
        } else if (bmi >= 23 && bmi < 24.9) {
            result.innerHTML += "<br>Bạn đang trong tình trạng tiền béo phì, cần áp dụng thực đơn ăn kiêng hợp lý cùng việc luyện tập khoa học để lấy lại vóc dáng chuẩn nhất.";
        } else if(bmi >= 25 && bmi < 29.9){
            result.innerHTML += "<br>Bạn đang ở nhóm béo phì độ I. Béo phì là một tình trạng bạn có một lượng mỡ trong cơ thể cao hơn mức độ an toàn cho sức khỏe. Với tình trạng này kéo dài cơ thể bạn có thể gặp nhiều vấn đề về sức khỏe và cả sinh hoạt.";
        }
          else if(bmi >= 30 && bmi < 39.9){
            result.innerHTML += "<br>Bạn đang ở nhóm béo phì độ II. Béo phì là một tình trạng bạn có một lượng mỡ trong cơ thể cao hơn mức độ an toàn cho sức khỏe. Với tình trạng này kéo dài cơ thể bạn có thể gặp nhiều vấn đề về sức khỏe và cả sinh hoạt.";
        }
        else{
            result.innerHTML += "<br>Bạn đang ở nhóm béo phì độ III. Béo phì là một tình trạng bạn có một lượng mỡ trong cơ thể cao hơn mức độ an toàn cho sức khỏe. Với tình trạng này kéo dài cơ thể bạn có thể gặp nhiều vấn đề về sức khỏe và cả sinh hoạt.";
        }
    });
</script>

@endsection
