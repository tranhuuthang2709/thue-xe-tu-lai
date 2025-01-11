@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Thêm mới xe</h3>
            <a href="{{ route('car.index') }}" class="ms-auto text-end btn btn-secondary">Quay lại</a>
        </div>

        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Thêm thông tin xe</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Tên xe -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="name" class="form-label">Tên xe</label>
                                <input type="text" name="name" class="form-control" placeholder="Nhập tên xe"
                                    value="{{ old('name') }}">
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

                            <div class="col-md-12 form-group mb-3">
                                <img id="preview-image" src="" alt="Ảnh xe" style="display: none; width: 100px;">
                            </div>

                            <!-- Ảnh phụ (secondary image) -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="secondary_image" class="form-label">Ảnh chi tiết xe</label>
                                <input type="file" name="secondary_image[]" id="secondary_image" class="form-control"
                                    multiple>
                            </div>

                            <!-- Hiển thị ảnh preview khi người dùng chọn ảnh -->
                            <div class="col-md-12 form-group mb-3">
                                <div id="image-preview-container"></div>
                            </div>


                            <!-- Thương hiệu -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="brand_id" class="form-label">Thương hiệu</label>
                                <select name="brand_id" class="form-control">
                                    <option value="">Chọn thương hiệu</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    value="{{ old('price') }}">
                                @if ($errors->has('price'))
                                    <span class="error-message text-danger">* {{ $errors->first('price') }}</span>
                                @endif
                            </div>

                            <!-- Giá giảm -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="discounted_price" class="form-label">Giá giảm (nếu có)</label>
                                <input type="text" name="discounted_price" class="form-control"
                                    placeholder="Nhập giá giảm nếu có" value="{{ old('discounted_price') }}">
                                @if ($errors->has('discounted_price'))
                                    <span class="error-message text-danger">*
                                        {{ $errors->first('discounted_price') }}</span>
                                @endif
                            </div>

                            <!-- Biển số xe -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="license_plate" class="form-label">Biển số xe</label>
                                <input type="text" name="license_plate" class="form-control"
                                    placeholder="Nhập biển số xe" value="{{ old('license_plate') }}">
                                @if ($errors->has('license_plate'))
                                    <span class="error-message text-danger">* {{ $errors->first('license_plate') }}</span>
                                @endif
                            </div>

                            <!-- Năm sản xuất -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="manufacture_year" class="form-label">Năm sản xuất</label>
                                <input type="text" name="manufacture_year" class="form-control"
                                    placeholder="Nhập năm sản xuất của xe" value="{{ old('manufacture_year') }}">
                                @if ($errors->has('manufacture_year'))
                                    <span class="error-message text-danger">*
                                        {{ $errors->first('manufacture_year') }}</span>
                                @endif
                            </div>

                            <!-- Loại nhiên liệu -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="fuel_type" class="form-label">Loại nhiên liệu</label>
                                <select name="fuel_type" class="form-control">
                                    <option value="Xăng" {{ old('fuel_type') == 'Xăng' ? 'selected' : '' }}>Xăng
                                    </option>
                                    <option value="Dầu" {{ old('fuel_type') == 'Dầu' ? 'selected' : '' }}>Dầu</option>
                                    <option value="Điện" {{ old('fuel_type') == 'Điện' ? 'selected' : '' }}>Điện
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
                                    value="{{ old('color') }}">
                                @if ($errors->has('color'))
                                    <span class="error-message text-danger">* {{ $errors->first('color') }}</span>
                                @endif
                            </div>

                            <!-- Hộp số -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="transmission" class="form-label">Hộp số</label>
                                <select name="transmission" class="form-control">
                                    <option value="Số tự động" {{ old('Số tự động') == 'automatic' ? 'selected' : '' }}>
                                        Số tự động</option>
                                    <option value="Số sàn" {{ old('Số sàn') == 'manual' ? 'selected' : '' }}>Số sàn
                                    </option>
                                </select>
                                @if ($errors->has('transmission'))
                                    <span class="error-message text-danger">* {{ $errors->first('transmission') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="seat" class="form-label">Số ghế</label>
                                <input type="text" name="seat" class="form-control" placeholder="Nhập số ghế"
                                    value="{{ old('seat') }}">
                                @if ($errors->has('seat'))
                                    <span class="error-message text-danger">* {{ $errors->first('color') }}</span>
                                @endif
                            </div>
                            <!-- Trạng thái -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" class="form-control">
                                    <option value="Có sẵn" {{ old('status') == 'Có sẵn' ? 'selected' : '' }}>Có sẵn
                                    </option>
                                    <option value="Đang thuê" {{ old('status') == 'Đang thuê' ? 'selected' : '' }}>Đang
                                        thuê
                                    </option>
                                    <option value="Đang bảo trì" {{ old('status') == 'Đang bảo trì' ? 'selected' : '' }}>
                                        Đang bảo trì</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="error-message text-danger">* {{ $errors->first('status') }}</span>
                                @endif
                            </div>

                            <!-- Tỉnh -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="province" class="form-label">Tỉnh/Thành phố</label>
                                <select name="province" id="province" class="form-control">
                                    <option value="">Chọn tỉnh</option>
                                </select>
                                <input type="hidden" name="province">
                            </div>

                            <!-- Quận -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="district" class="form-label">Huyện/Quận</label>
                                <select name="district" id="district" class="form-control">
                                    <option value="">Chọn quận</option>
                                </select>
                                <input type="hidden" name="district">
                            </div>

                            <!-- Phường -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="ward" class="form-label">Xã/phường</label>
                                <select name="ward" id="ward" class="form-control">
                                    <option value="">Chọn xã</option>
                                </select>
                                <input type="hidden" name="ward">
                            </div>

                            <!-- Đường -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="street" class="form-label">Đường</label>
                                <input type="text" name="street" class="form-control" placeholder="Nhập tên đường"
                                    value="{{ old('street') }}">
                            </div>

                            <!-- Mô tả -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea name="description" id="description" rows="10" class="form-control">{{ old('description') }}</textarea>
                            </div>

                            <!-- Nút lưu -->
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-success">Lưu</button>
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
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageElement = document.getElementById('preview-image');
                    imageElement.src = e.target.result;
                    imageElement.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
        document.getElementById('secondary_image').addEventListener('change', function(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('image-preview-container');

            // Xóa preview cũ trước khi hiển thị ảnh mới
            previewContainer.innerHTML = '';

            // Duyệt qua tất cả các ảnh được chọn
            Array.from(files).forEach(function(file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.marginRight = '10px';
                    img.style.marginBottom = '10px';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
