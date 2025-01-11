@extends('user.index')

@section('content')
    <section class="order-summary py-5">
        <div class="container">
            <div class="order-details">
                <h3 class="font-weight-bold text-center mb-5">Đơn hàng của bạn</h3>

                <!-- Kiểm tra nếu có đơn hàng -->
                @if (!$bookings->isEmpty())
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Mã đơn hàng</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Phương thức thanh toán</th>
                                <th scope="col">Số tiền</th>
                                <th scope="col" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $booking->status }}</td>
                                    <td>{{ $booking->payment_method }}</td>
                                    <td>{{ number_format($booking->total_amount) }} VNĐ</td>
                                    <td>
                                        <a href="{{ route('user.bookings_detail', $booking->id) }}"
                                            class="btn btn-outline-primary text-dark">
                                            Chi tiết
                                        </a>
                                        @if ($booking->status != 'Đã hủy')
                                            <a href="{{ route('user.bookings_cancel', $booking->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn muốn hủy đơn?')"
                                                class="btn btn-outline-danger text-dark">
                                                Hủy đơn
                                            </a>
                                        @elseif($booking->status = 'Đã hủy')
                                            <p class="btn btn-outline- text-dark">
                                                Đã hủy
                                            </p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">Bạn chưa có đơn hàng nào cả</h4>
                        <p>Vui lòng chọn sản phẩm để đặt hàng.</p>
                        <hr />
                    </div>
                @endif

                <!-- Các nút điều hướng -->
                <div class="d-flex justify-content-center mt-5">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg mr-3">Trở về trang chủ</a>
                    @if ($bookings->isEmpty())
                        <a href="{{ route('cart.index') }}" class="btn btn-secondary btn-lg">Quay lại giỏ hàng</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
