<!-- resources/views/user/booking_detail.blade.php -->

@extends('user.index')

@section('content')
    <section class="order-summary py-5">
        <div class="container-fuild">
            <div class="order-details">
                <h3 class="font-weight-bold text-center mb-5">Chi tiết đơn hàng </h3>
                <!-- Chi tiết các sản phẩm trong đơn hàng -->
                <div class="order-items mt-4">
                    <h4 class="font-weight-bold">Chi tiết sản phẩm trong đơn hàng:</h4>
                    <br>
                    <table class="table table-striped table-bordered" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên xe</th>
                                <th class="text-center">Ảnh</th>
                                <th class="text-center">Giá theo ngày</th>
                                <th class="text-center">Trạng thái giao xe</th>
                                <th class="text-center">Địa điểm và thời gian nhận xe</th>
                                <th class="text-center">Địa điểm và thời gian trả xe</th>
                                <th class="text-center">Trạng thái trả xe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings_detail as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td>{{ $item->car->name }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/img_car/' . $item->car->main_image) }}"
                                            alt="{{ $item->car->name }}" class="img-fluid" style="max-width: 80px;">
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($item->rental_price) }} VNĐ
                                        <br>
                                        @if ($item->pickup_type === 'Giao xe tận nơi')
                                            <small>+ Phí giao xe:100,000 VNĐ</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $item->pickup_status }}
                                    </td>
                                    <td class="text-center">
                                        @if ($item->pickupAddress)
                                            {{ $item->pickupAddress->street }},
                                            {{ $item->pickupAddress->ward }},
                                            {{ $item->pickupAddress->district }} ,
                                            {{ $item->pickupAddress->province }}<br>
                                            Ngày, giờ: {{ $item->pickupAddress->pickup_time }}
                                        @else
                                            Vui lòng chờ nhân viên
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $item->returnAddress->street }},
                                        {{ $item->returnAddress->ward }},
                                        {{ $item->returnAddress->district }} ,
                                        {{ $item->returnAddress->province }}<br>
                                        Ngày, giờ: {{ $item->returnAddress->return_time }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->return_status !== null ? $item->return_status : 'Chưa nhận xe' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Nút điều hướng -->
                <div class="d-flex justify-content-center mt-5">
                    <a href="{{ route('user.bookings') }}" class="btn btn-secondary btn-lg mr-3 me-5">Quay lại danh sách
                        đơn
                        hàng</a>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Trở về trang chủ</a>
                </div>
            </div>
        </div>
    </section>
@endsection
