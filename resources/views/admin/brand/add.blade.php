@extends('admin.index')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Thêm mới thương hiệu </h3>
            <a href="{{ route('category.index') }}" class="ms-auto text-end btn btn-secondary">Quay lại</a>
        </div>
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Thêm thương hiệu</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Tên thương hiệu</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên thương hiệu"
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="error-message text-danger">* {{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Ảnh thương hiệu</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @if ($errors->has('image'))
                                <span class="error-message
                                text-danger">*
                                    {{ $errors->first('image') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">

                            <img id="preview-image" src="" alt="Ảnh thương hiệu"
                                style="display: none; width: 100px;">
                        </div>
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="{{ route('brand.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            var file = event.target.files[0]; // Lấy file người dùng chọn
            if (file) {
                var reader = new FileReader(); // Tạo một FileReader mới để đọc file
                reader.onload = function(e) { // Khi đọc file xong, thực hiện hàm này
                    var imageElement = document.getElementById(
                        'preview-image'); // Lấy thẻ <img> dùng để hiển thị ảnh
                    imageElement.src = e.target.result; // Gán đường dẫn ảnh cho thẻ <img>
                    imageElement.style.display = 'block'; // Hiển thị ảnh lên trang
                };
                reader.readAsDataURL(file); // Đọc file dưới dạng URL và gọi hàm reader.onload khi xong
            }
        });
    </script>
@endsection
