@extends('admin.index')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Sửa mới thương hiệu</h3>
            <a href="{{ route('category.index') }}" class="ms-auto text-end btn btn-secondary">Quay lại</a>
        </div>
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Sửa thương hiệu</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <!-- Tên thương hiệu -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Tên thương hiệu</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Nhập tên thương hiệu" value="{{ $brand->name }}">
                            @if ($errors->has('name'))
                                <span class="error-message text-danger">* {{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <!-- Ảnh thương hiệu -->
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Thay đổi ảnh thương hiệu</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <span id="file-name" class="text-muted">Chưa có tệp nào được chọn</span>
                            @if ($errors->has('image'))
                                <span class="error-message text-danger">* {{ $errors->first('image') }}</span>
                            @endif
                        </div>

                        <!-- Hiển thị ảnh cũ -->
                        @if ($brand->image)
                            <div class="mb-3">
                                <label class="form-label">Ảnh hiện tại:</label>
                                <div>
                                    <img id="current-image" src="{{ asset('storage/img_brand/' . $brand->image) }}"
                                        alt="Ảnh thương hiệu hiện tại" style="width: 100px;">
                                </div>
                            </div>
                        @endif

                        <!-- Ảnh xem trước -->
                        <div class="form-group mb-3" id="preview-container" style="display: none;">
                            <label class="form-label">Ảnh xem trước:</label>
                            <img id="preview-image" src="#" alt="Ảnh xem trước" style="width: 100px;">
                        </div>

                        <!-- Nút -->
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="{{ route('brand.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            var file = event.target.files[0]; // File người dùng chọn
            var previewContainer = document.getElementById('preview-container');
            var previewImage = document.getElementById('preview-image');
            var currentImage = document.getElementById('current-image');
            var fileNameElement = document.getElementById('file-name');

            if (file) {
                // Cập nhật tên file
                fileNameElement.textContent = file.name;

                // Hiển thị ảnh xem trước
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';

                    // Ẩn ảnh hiện tại
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            } else {
                // Reset nếu không chọn file
                fileNameElement.textContent = "Chưa có tệp nào được chọn";
                previewContainer.style.display = 'none';

                // Hiển thị lại ảnh hiện tại
                if (currentImage) {
                    currentImage.style.display = 'block';
                }
            }
        });
    </script>
@endsection
