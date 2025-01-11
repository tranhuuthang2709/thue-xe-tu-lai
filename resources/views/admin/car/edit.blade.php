@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Sửa thông tin xe</h3>
            <a href="{{ route('car.index') }}" class="ms-auto text-end btn btn-secondary">Quay lại</a>
        </div>

        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Sửa thông tin xe</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('car.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Tên xe -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="name" class="form-label">Tên xe</label>
                                <input type="text" name="name" class="form-control" placeholder="Nhập tên xe"
                                    value="{{ old('name', $car->name) }}">
                                @if ($errors->has('name'))
                                    <span class="error-message text-danger">* {{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <!-- Ảnh chính -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="main_image" class="form-label">Ảnh chính</label>
                                <input type="file" name="main_image" id="main_image" class="form-control">
                                @if ($errors->has('main_image'))
                                    <span class="error-message text-danger">* {{ $errors->first('main_image') }}</span>
                                @endif
                            </div>

                            <!-- Hiển thị ảnh chính hiện tại -->
                            @if ($car->main_image)
                                <div class="col-md-12 form-group mb-3">
                                    <label class="form-label">Ảnh chính hiện tại:</label>
                                    <div>
                                        <img id="current-image" src="{{ asset('storage/img_car/' . $car->main_image) }}"
                                            alt="Ảnh chính xe" style="width: 100px;">
                                    </div>
                                </div>
                            @endif

                            <!-- Ảnh xem trước -->
                            <div class="col-md-12 form-group mb-3">
                                <img id="preview-image" src="" alt="Ảnh xe" style="display: none; width: 100px;">
                            </div>

                            <!-- Ảnh phụ (secondary image) -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="secondary_image" class="form-label">Thêm ảnh chi tiết xe </label>
                                <input type="file" name="secondary_image[]" id="secondary_image" class="form-control"
                                    multiple>
                            </div>

                            <!-- Hiển thị ảnh phụ -->
                            <div class="col-md-12 form-group mb-3 ">
                                <label>Ảnh chi tiết hiện tại</lable>
                                    <div id="image-preview-container">
                                        @foreach ($car->images as $image)
                                            <div class="image-item mt-3">
                                                <img src="{{ asset('storage/img_car/' . $image->image) }}"
                                                    alt="Ảnh chi tiết xe"
                                                    style="width: 100px; margin-right: 10px; margin-bottom: 10px;">
                                                <a href="{{ route('car.deleteImage', $image->id) }}"
                                                    class="delete-image-form">X</a>
                                            </div>
                                        @endforeach
                                    </div>
                            </div>

                            <!-- Container để hiển thị ảnh mới chọn (chưa lưu) với icon xóa -->
                            <div id="new-image-preview-container"></div>


                            <!-- Thương hiệu -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="brand_id" class="form-label">Thương hiệu</label>
                                <select name="brand_id" class="form-control">
                                    <option value="">Chọn thương hiệu</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('brand_id'))
                                    <span class="error-message text-danger">* {{ $errors->first('brand_id') }}</span>
                                @endif
                            </div>

                            <!-- Danh mục -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="category_id" class="form-label">Danh mục</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $car->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="error-message text-danger">* {{ $errors->first('category_id') }}</span>
                                @endif
                            </div>

                            <!-- Giá xe -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="price" class="form-label">Giá thuê theo ngày</label>
                                <input type="text" name="price" class="form-control" placeholder="Nhập giá xe"
                                    value="{{ old('price', $car->price) }}">
                                @if ($errors->has('price'))
                                    <span class="error-message text-danger">* {{ $errors->first('price') }}</span>
                                @endif
                            </div>

                            <!-- Giá giảm -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="discounted_price" class="form-label">Giá giảm (nếu có)</label>
                                <input type="text" name="discounted_price" class="form-control"
                                    placeholder="Nhập giá giảm nếu có"
                                    value="{{ old('discounted_price', $car->discounted_price) }}">
                                @if ($errors->has('discounted_price'))
                                    <span class="error-message text-danger">*
                                        {{ $errors->first('discounted_price') }}</span>
                                @endif
                            </div>

                            <!-- Biển số xe -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="license_plate" class="form-label">Biển số xe</label>
                                <input type="text" name="license_plate" class="form-control"
                                    placeholder="Nhập biển số xe" value="{{ old('license_plate', $car->license_plate) }}">
                                @if ($errors->has('license_plate'))
                                    <span class="error-message text-danger">* {{ $errors->first('license_plate') }}</span>
                                @endif
                            </div>

                            <!-- Năm sản xuất -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="manufacture_year" class="form-label">Năm sản xuất</label>
                                <input type="text" name="manufacture_year" class="form-control"
                                    placeholder="Nhập năm sản xuất của xe"
                                    value="{{ old('manufacture_year', $car->manufacture_year) }}">
                                @if ($errors->has('manufacture_year'))
                                    <span class="error-message text-danger">*
                                        {{ $errors->first('manufacture_year') }}</span>
                                @endif
                            </div>

                            <!-- Loại nhiên liệu -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="fuel_type" class="form-label">Loại nhiên liệu</label>
                                <select name="fuel_type" class="form-control">
                                    <option value="Xăng"
                                        {{ old('fuel_type', $car->fuel_type) == 'Xăng' ? 'selected' : '' }}>Xăng
                                    </option>
                                    <option value="Dầu"
                                        {{ old('fuel_type', $car->fuel_type) == 'Dầu' ? 'selected' : '' }}>Dầu</option>
                                    <option value="Điện"
                                        {{ old('fuel_type', $car->fuel_type) == 'Điện' ? 'selected' : '' }}>Điện
                                    </option>
                                </select>
                                @if ($errors->has('fuel_type'))
                                    <span class="error-message text-danger">* {{ $errors->first('fuel_type') }}</span>
                                @endif
                            </div>

                            <!-- Màu xe -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="color" class="form-label">Màu xe</label>
                                <input type="text" name="color" class="form-control" placeholder="Nhập màu xe"
                                    value="{{ old('color', $car->color) }}">
                                @if ($errors->has('color'))
                                    <span class="error-message text-danger">* {{ $errors->first('color') }}</span>
                                @endif
                            </div>

                            <!-- Hộp số -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="transmission" class="form-label">Hộp số</label>
                                <select name="transmission" class="form-control">
                                    <option value="Số tự động"
                                        {{ old('transmission', $car->transmission) == 'Số tự động' ? 'selected' : '' }}>Số
                                        tự động</option>
                                    <option value="Số sàn"
                                        {{ old('transmission', $car->transmission) == 'Số sàn' ? 'selected' : '' }}>Số sàn
                                    </option>
                                </select>
                                @if ($errors->has('transmission'))
                                    <span class="error-message text-danger">* {{ $errors->first('transmission') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="seat" class="form-label">Số ghế</label>
                                <input type="text" name="seat" class="form-control" placeholder="Nhập số ghế"
                                    value="{{ old('seat', $car->seat) }}">
                                @if ($errors->has('seat'))
                                    <span class="error-message text-danger">* {{ $errors->first('color') }}</span>
                                @endif
                            </div>
                            <!-- Trạng thái -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" class="form-control">
                                    <option value="Có sẵn"
                                        {{ old('status', $car->status) == 'có sẵn' ? 'selected' : '' }}>Có sẵn</option>
                                    <option value="Đang thuê"
                                        {{ old('status', $car->status) == 'Đang thuê' ? 'selected' : '' }}>Đang thuê
                                    </option>
                                    <option value="Đang bảo trì"
                                        {{ old('status', $car->status) == 'Đang bảo trì' ? 'selected' : '' }}>Đang bảo
                                        trì</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="error-message text-danger">* {{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <!-- Tỉnh -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="province" class="form-label">Tỉnh/Thành phố</label>
                                <select name="province" id="province" class="form-control">
                                    <option value="{{ $address->province }}">{{ $address->province }}</option>
                                </select>
                                <input type="hidden" name="province">

                            </div>

                            <!-- Huyện -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="district" class="form-label">Huyện/Quận</label>
                                <select name="district" id="district" class="form-control">
                                    <option value="{{ $address->district }}">{{ $address->district }}</option>
                                </select>
                                <input type="hidden" name="district">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="ward" class="form-label">Xã/phường</label>
                                <select name="ward" id="ward" class="form-control">
                                    <option value="{{ $address->ward }}">{{ $address->ward }}</option>
                                </select>
                                <input type="hidden" name="ward">
                            </div>
                            <!-- Đường -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="street" class="form-label">Đường</label>
                                <input type="text" name="street" class="form-control" placeholder="Nhập tên đường"
                                    value="{{ old('street', $address->street) }}">
                            </div>
                            <!-- Mô tả -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea name="description" id="description" rows="10" class="form-control">{{ old('description', $car->description) }}</textarea>
                            </div>

                            <!-- Nút lưu -->
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-success">Cập nhật</button>
                                <a href="{{ route('car.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('main_image').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var currentImageElement = document.getElementById('current-image'); // Ảnh chính cũ
            var previewImageElement = document.getElementById('preview-image'); // Ảnh xem trước

            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Ẩn ảnh cũ và hiển thị ảnh mới
                    if (currentImageElement) {
                        currentImageElement.style.display = 'none'; // Ẩn ảnh cũ
                    }

                    // Hiển thị ảnh mới
                    previewImageElement.src = e.target.result;
                    previewImageElement.style.display = 'block'; // Hiển thị ảnh mới
                };
                reader.readAsDataURL(file);
            }
        });


        document.getElementById('secondary_image').addEventListener('change', function(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('new-image-preview-container');

            // Xóa ảnh cũ trong giao diện trước khi thêm mới
            previewContainer.innerHTML = '';
            secondary_img = Array.from(files); // Lưu các file đã chọn vào mảng

            // Hiển thị ảnh mới chọn
            secondary_img.forEach(function(file, index) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Tạo phần tử hình ảnh mới
                    var imageItem = document.createElement('div');
                    imageItem.classList.add('image-item');

                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.marginRight = '10px';
                    img.style.marginBottom = '10px';

                    // Tạo nút xóa
                    var deleteIcon = document.createElement('a');
                    deleteIcon.href = 'javascript:void(0);'; // Không liên kết đến URL
                    deleteIcon.classList.add('delete-image-form');
                    deleteIcon.textContent = 'X';

                    // Xử lý khi bấm nút xóa
                    deleteIcon.addEventListener('click', function() {
                        // Tìm chỉ số của ảnh trong giao diện
                        var imageIndex = Array.from(previewContainer.children).indexOf(
                            imageItem);

                        // Loại bỏ file tương ứng trong mảng
                        secondary_img.splice(imageIndex, 1);

                        // Cập nhật lại danh sách file cho input
                        updateFileList();

                        // Xóa phần tử ảnh khỏi giao diện
                        imageItem.remove();
                    });

                    // Thêm ảnh và nút xóa vào giao diện
                    imageItem.appendChild(img);
                    imageItem.appendChild(deleteIcon);
                    previewContainer.appendChild(imageItem);
                };
                reader.readAsDataURL(file);
            });
        });

        // Cập nhật danh sách file của input
        function updateFileList() {
            var dataTransfer = new DataTransfer(); // Tạo một đối tượng DataTransfer
            secondary_img.forEach(function(file) {
                dataTransfer.items.add(file); // Thêm các file còn lại vào DataTransfer
            });

            document.getElementById('secondary_image').files = dataTransfer.files; // Gán lại danh sách file
        }
    </script>
@endsection
