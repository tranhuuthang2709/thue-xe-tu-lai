@extends('user.index')

@section('content')
    <section class="order-confirmation py-5">
        <div class="container-fluid">
            <div class="confirm-order">
                @if ($carts->isEmpty())
                    <h3 class="font-weight-bold text-center">Giỏ hàng của bạn</h3>
                    <div class="alert alert-warning text-center">
                        <h5 class="text-danger">Bạn chưa thêm sản phẩm nào vào giỏ hàng</h5>
                        <p class="mb-0">Xin vui lòng chọn xe để bắt đầu quá trình thuê xe.</p>
                    </div>
                @else
                    <div class="section-title mb-4 text-center">
                        <h3 class="font-weight-bold">Giỏ hàng của bạn</h3>
                    </div>

                    <!-- Bảng thông tin giỏ hàng -->
                    <div class="booking-details order-confirm-box">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>Lỗi!</strong> {{ session('error') }}
                            </div>
                        @endif

                        <table class="table table-striped table-hover" style="font-size: 14px">
                            <thead class="thead-dark">
                                <tr>
                                    <th>STT</th>
                                    <th class="text-center">Tên xe</th>
                                    <th>Ảnh</th>
                                    <th class="text-center">Giá</th>
                                    <th class="text-center">Phương thức</th>
                                    <th class="text-center">Địa điểm và thời gian nhận xe</th>
                                    <th class="text-center">Địa điểm và thời gian trả xe</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span class="font-weight-bold">{{ $item->car->name }}</span></td>
                                        <td>
                                            <img src="{{ asset('storage/img_car/' . $item->car->main_image) }}"
                                                alt="{{ $item->car->name }}" class="img-fluid" style="max-width: 70px;">
                                        </td>
                                        <td class="text-center">
                                            <span>
                                                {{ number_format($item->car->discounted_price ? $item->car->discounted_price : $item->car->price) }}
                                                VND
                                            </span>
                                        </td>
                                        <td>{{ $item->pickup_type }}</td>
                                        <td style="font-size:13px">
                                            <ul class="list-unstyled mb-0">
                                                @if ($item->pickupAddress)
                                                    <li>{{ $item->pickupAddress->street }},
                                                        {{ $item->pickupAddress->ward }},
                                                        {{ $item->pickupAddress->district }},
                                                        {{ $item->pickupAddress->province }}</li>
                                                    <li>Ngày, giờ: {{ $item->pickupAddress->pickup_time }}</li>
                                                @else
                                                    <p>Vui lòng chờ nhân viên chọn địa chỉ lấy xe</p>
                                                @endif
                                            </ul>
                                        </td>
                                        <td style="font-size:13px">
                                            <ul class="list-unstyled mb-0">
                                                <li>{{ $item->returnAddress->street }},
                                                    {{ $item->returnAddress->ward }},
                                                    {{ $item->returnAddress->district }},
                                                    {{ $item->returnAddress->province }}</li>
                                                <li>Ngày, giờ: {{ $item->returnAddress->return_time }}</li>
                                            </ul>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('cart.edit', $item->id) }}" class="btn btn-primary btn-sm"
                                                style="color:black">Sửa</a>
                                            <a href="{{ route('cart.delete', $item->id) }}"
                                                onclick="return confirm('Bạn có muốn xóa xe ra khỏi giỏ hàng không?')"
                                                class="btn btn-danger btn-sm" style="color: white">Xóa</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Phần thanh toán -->
                    <div class="row">
                        <div class="col-md-6">

                            <form action="{{ route('vnpay_payment') }}" method="post" onsubmit="return checkPhone()">
                                @csrf
                                <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">

                                <div class="payment-method mt-3">
                                    <h4>Chọn phương thức thanh toán:</h4>

                                    <!-- Phương thức thanh toán tiền mặt -->
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="payment_method_cod"
                                            name="payment_method" value="COD" checked>
                                        <label class="form-check-label" for="payment_method_cod">Thanh toán bằng tiền
                                            mặt</label>
                                    </div>

                                    <!-- Phương thức thanh toán qua VNPAY -->
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="payment_method_vnpay"
                                            name="payment_method" value="VNPAY">
                                        <label class="form-check-label" for="payment_method_vnpay">Thanh toán qua
                                            VNPAY</label>
                                    </div>
                                </div>

                        </div>
                        <div class="total-price mt-3 col-md-6">
                            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                                <h4 class="card-title text-center">Tổng thanh toán</h4>
                                <ul class="list-unstyled">
                                    @php
                                        $totalPrice = 0; // Khởi tạo lại tổng giá ngoài vòng lặp
                                    @endphp
                                    @foreach ($carts as $item)
                                        @php
                                            $carPrice = $item->car->discounted_price
                                                ? $item->car->discounted_price
                                                : $item->car->price;
                                            $totalCar = $carPrice * $item->rental_days; // Tính tổng giá của xe
                                            if ($item->pickup_type === 'Giao xe tận nơi') {
                                                $totalCar += 100000; // Cộng phí giao xe tận nơi
                                            }
                                            $totalPrice += $totalCar; // Cộng vào tổng thanh toán
                                        @endphp
                                        <li>
                                            <p>Tên xe: {{ $item->car->name }}</p>
                                            <span>Số ngày: {{ $item->rental_days }}</span>

                                            <span>Giá: {{ number_format($carPrice) }} VND</span>
                                            @if ($item->pickup_type === 'Giao xe tận nơi')
                                                <br><span class="text-warning">+ Phí giao xe tận nơi: 100,000 VND</span>
                                            @endif
                                            <p>Tổng: {{ number_format($totalCar) }} VND</p>
                                            <hr>
                                        </li>
                                    @endforeach
                                </ul>
                                <hr>
                                <h5 class="text-center">Tổng cộng: <span id="total_payment"
                                        class="text-primary">{{ number_format($totalPrice) }} VND</span></h5>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <a href="{{ route('cart.clear') }}"
                                onclick="return confirm('Bạn có muốn xóa hết giỏ hàng không?')"
                                class="btn btn-danger btn-lg mx-3">Xóa hết giỏ hàng</a>
                            <button type="submit" class="btn btn-primary btn-lg mx-3">
                                <i class="feather-bar-chart me-2"></i>Thanh toán
                            </button>
                        </div>
                        </form>
                @endif
            </div>
        </div>
        </div>
    </section>

    <script>
        function checkPhone() {
            var phone = "{{ Auth::user()->phone_number }}";
            if (!phone) {
                alert("Vui lòng cập nhật số điện thoại trước khi thanh toán.");
                window.location.href = "{{ route('profile') }}";
                return false;
            }
            return true;
        }
    </script>
@endsection
