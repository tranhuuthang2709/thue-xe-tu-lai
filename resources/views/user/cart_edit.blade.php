@extends('user.index')

@section('content')
    <section class="order-confirmation py-5">
        <div class="container">
            <div class="confirm-order">
                <!-- Tiêu đề -->
                <div class="section-title text-center mb-5">
                    <h3 class="font-weight-bold">Chỉnh sửa thông tin giỏ hàng</h3>
                </div>

                <!-- Thông tin xe -->
                <div class="car-info mb-4 p-2 border rounded shadow-sm">
                    <h4 class="font-weight-bold mb-3 text-center">Thông tin xe</h4>
                    <div class="row">
                        <!-- Hình ảnh xe -->
                        <div class="col-md-4 d-flex justify-content-center mb-3 mb-md-0">
                            <img src="{{ asset('storage/img_car/' . $cart->car->main_image) }}" alt="{{ $cart->car->name }}"
                                class="img-fluid rounded" style="max-width: 250px; height: auto;">
                        </div>

                        <!-- Thông tin xe -->
                        <div class="col-md-8">
                            <h5 class="font-weight-bold">{{ $cart->car->name }}</h5>
                            <p class="mb-2">
                                <strong>Giá thuê:</strong>
                                <span
                                    class="text-success">{{ number_format($cart->car->discounted_price ? $cart->car->discounted_price : $cart->car->price) }}
                                    VNĐ/ngày</span>
                            </p>
                            <p class="mb-2"><strong>Hãng xe:</strong> {{ $cart->car->brand->name }}</p>
                            <p class="mb-2"><strong>Năm sản xuất:</strong> {{ $cart->car->production_year }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form chỉnh sửa -->
                <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <!-- Phương thức nhận xe -->
                        <div class="form-group col-md-2">
                            <label for="pickup_type" class="font-weight-bold">Phương thức nhận xe</label>
                            <select name="pickup_type" id="pickup_type" class="form-control" required>
                                <option value="Tự đến lấy xe" {{ $cart->pickup_type == 'Tự đến lấy xe' ? 'selected' : '' }}>
                                    Tự đến lấy xe
                                </option>
                                <option value="Giao xe tận nơi"
                                    {{ $cart->pickup_type == 'Giao xe tận nơi' ? 'selected' : '' }}>
                                    Giao xe tận nơi</option>
                            </select>
                        </div>
                    </div>

                    <!-- Thời gian nhận xe và Địa chỉ nhận xe -->
                    <div id="pickup_info" class="row">
                        <div class="col-md-12">
                            <h5 class="font-weight-bold mt-4">Địa chỉ nhận xe</h5>
                            <div class="row">
                                <div class="col-md-2 mb-3" id="pickup_time_field">
                                    <label for="pickup_time" class="font-weight-bold">Thời gian nhận xe</label>
                                    <input type="datetime-local" id="pickup_time" name="pickup_time" class="form-control"
                                        value="{{ old('pickup_time', $cart->pickupAddress->pickup_time) }}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label>Tỉnh/Thành phố</label>
                                    <input type="text" name="pickup_province" class="form-control"
                                        value="{{ old('pickup_province', $cart->pickupAddress->province ?? '') }}"
                                        placeholder="Tỉnh/Thành phố">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label>Quận/Huyện</label>
                                    <input type="text" name="pickup_district" class="form-control"
                                        value="{{ old('pickup_district', $cart->pickupAddress->district ?? '') }}"
                                        placeholder="Quận/Huyện">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label>Xã/Phường</label>
                                    <input type="text" name="pickup_ward" class="form-control"
                                        value="{{ old('pickup_ward', $cart->pickupAddress->ward ?? '') }}"
                                        placeholder="Phường/Xã">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label>Số nhà/Tòa nhà</label>
                                    <input type="text" name="pickup_street" class="form-control"
                                        value="{{ old('pickup_street', $cart->pickupAddress->street ?? '') }}"
                                        placeholder="Địa chỉ nhận xe">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Địa chỉ trả xe -->
                    <h5 class="font-weight-bold mt-4">Địa chỉ trả xe</h5>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="return_time" class="font-weight-bold">Thời gian trả xe</label>
                            <input type="datetime-local" id="return_time1" name="return_time1" class="form-control"
                                value="{{ old('return_time1', $cart->returnAddress->return_time ?? '') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Tỉnh/Thành phố</label>
                            <input type="text" name="return_province" class="form-control"
                                value="{{ old('return_province', $cart->returnAddress->province ?? '') }}"
                                placeholder="Tỉnh/Thành phố">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Quận/Huyện</label>
                            <input type="text" name="return_district" class="form-control"
                                value="{{ old('return_district', $cart->returnAddress->district ?? '') }}"
                                placeholder="Quận/Huyện">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Xã/Phường</label>
                            <input type="text" name="return_ward" class="form-control"
                                value="{{ old('return_ward', $cart->returnAddress->ward ?? '') }}" placeholder="Phường/Xã">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Số nhà/Tòa nhà</label>
                            <input type="text" name="return_street" class="form-control"
                                value="{{ old('return_street', $cart->returnAddress->street ?? '') }}"
                                placeholder="Địa chỉ trả xe">
                        </div>
                    </div>

                    <input type="hidden" name="rental_days" id="rental_days_value">
                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('cart.index') }}" class="btn btn-danger btn-lg">Hủy bỏ</a>
                        <button type="submit" class="btn btn-success btn-lg">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pickupType = document.getElementById('pickup_type');
            const pickupTimeField = document.getElementById('pickup_time_field');
            const pickupAddress = document.querySelector('#pickup_info .col-md-12');
            const pickupFields = pickupAddress.querySelectorAll('.col-md-2');
            const rentalDaysInput = document.getElementById('rental_days_value');
            const pickupTimeInput = document.getElementById('pickup_time');
            const returnTimeInput = document.getElementById('return_time1');

            // Kiểm tra phương thức nhận xe khi tải trang lần đầu
            togglePickupInfo(pickupType.value);
            calculateRentalDays(); // Tính số ngày khi tải trang

            // Lắng nghe sự thay đổi phương thức nhận xe
            pickupType.addEventListener('change', function() {
                togglePickupInfo(pickupType.value);
            });

            // Lắng nghe sự thay đổi thời gian nhận và trả xe để tính toán số ngày
            pickupTimeInput.addEventListener('change', calculateRentalDays);
            returnTimeInput.addEventListener('change', calculateRentalDays);

            // Hàm ẩn/hiện các trường liên quan đến địa chỉ và thời gian nhận xe
            function togglePickupInfo(pickupTypeValue) {
                if (pickupTypeValue === 'Tự đến lấy xe') {
                    // Khi "Tự đến lấy xe", ẩn các trường địa chỉ nhận xe và chỉ hiển thị thời gian
                    pickupFields.forEach(field => field.classList.add('d-none'));
                    pickupTimeField.classList.remove('d-none');
                } else {
                    // Khi "Giao xe tận nơi", hiển thị tất cả các trường
                    pickupFields.forEach(field => field.classList.remove('d-none'));
                    pickupTimeField.classList.remove('d-none');
                }
            }

            // Hàm tính số ngày thuê xe
            function calculateRentalDays() {
                const pickupTime = new Date(pickupTimeInput.value);
                const returnTime = new Date(returnTimeInput.value);

                // Kiểm tra nếu cả 2 thời gian đều có giá trị hợp lệ
                if (!isNaN(pickupTime) && !isNaN(returnTime) && returnTime > pickupTime) {
                    const timeDiff = returnTime - pickupTime;
                    const rentalDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); // Chuyển đổi thành số ngày
                    rentalDaysInput.value = rentalDays;
                } else {
                    rentalDaysInput.value = 0; // Nếu không hợp lệ, set số ngày là 0
                }
            }
        });
    </script>
@endsection
