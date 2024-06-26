@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <form action="{{ route('posts.add') }}" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Bài Viết</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Nhập tên Bài Viết">
                    </div>
                </div>
            </div>

            

            <div class="form-group">
                <label>Nội Dung</label>
                <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Bài Viết</label>
                <input type="file"  class="form-control" id="upload" multiple>
                <div id="image_show">

                </div>
                <input type="hidden" name="thumb" id="thumb">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Bài Viết</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection



<!-- <script>
    document.getElementById('upload').addEventListener('change', function() {
        var files = this.files;
        var imagesContainer = document.getElementById('image_show');
        imagesContainer.innerHTML = ''; // Xóa các hình ảnh hiện tại

        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            var image = new Image();

            reader.onload = (function(img) {
                return function(e) {
                    img.src = e.target.result;
                };
            })(image);

            reader.readAsDataURL(files[i]);

            imagesContainer.appendChild(image);
        }

        // Cập nhật giá trị của input hidden
        var thumbsInput = document.getElementById('thumbs');
        thumbsInput.value = JSON.stringify(Array.from(files).map(file => file.name));
    });
</script> -->

<script>
    document.getElementById('upload').addEventListener('change', function() {
        var files = this.files;
        var imagesContainer = document.getElementById('image_show');
        imagesContainer.innerHTML = ''; // Xóa các hình ảnh hiện tại

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            
            // Kiểm tra nếu file không phải là hình ảnh thì bỏ qua
            if (!file.type.match('image.*')) {
                alert('Vui lòng chỉ chọn các tệp hình ảnh (jpeg, png, jpg, gif)');
                continue;
            }

            var reader = new FileReader();
            var image = new Image();

            reader.onload = (function(img) {
                return function(e) {
                    img.src = e.target.result;
                };
            })(image);

            reader.readAsDataURL(file);

            imagesContainer.appendChild(image);
        }

        // Cập nhật giá trị của input hidden
        var thumbsInput = document.getElementById('thumbs');
        thumbsInput.value = JSON.stringify(Array.from(files).map(file => file.name));
    });
    
</script>
