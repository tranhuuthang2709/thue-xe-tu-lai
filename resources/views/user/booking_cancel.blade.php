@extends('user.index')

@section('content')
    <section class="refund-form py-5 bg-light">
        <div class="container">
            <h3 class="font-weight-bold text-center mb-4 text-uppercase">Thông tin chuyển khoản hoàn tiền</h3>

            <!-- Hiển thị thông tin đơn hàng -->
            <div class="order-details mb-4 p-4 bg-white rounded shadow-sm">
                <p><strong>Mã đơn hàng:</strong> {{ $booking->id }}</p>
                <p><strong>Ngày đặt:</strong> {{ $booking->created_at->format('d/m/Y H:i:s') }}</p>
                <p><strong>Trạng thái:</strong> <span class="badge badge-info">{{ $booking->status }}</span></p>
                <p><strong>Tổng tiền:</strong> {{ number_format($booking->total_amount) }} VNĐ</p>
            </div>

            <!-- Hiển thị thông tin chi tiết đơn hàng -->
            <h4 class="font-weight-bold mb-3">Chi tiết đơn hàng</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Tên xe</th>
                            <th scope="col">Biển số</th>
                            <th scope="col">Phương thức</th>
                            <th scope="col">Giá xe</th>
                            <th scope="col">Số ngày</th>
                            <th scope="col">Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookingDetail as $bookingDetail)
                            <tr>
                                <td>{{ $bookingDetail->car->name }}</td>
                                <td>{{ $bookingDetail->car->license_plate }}</td>
                                <td>{{ $bookingDetail->pickup_type }}</td>
                                <td>{{ number_format($bookingDetail->rental_price) }} VND</td>
                                <td>{{ $bookingDetail->rental_days }}</td>
                                <td>{{ number_format($bookingDetail->rental_days * $bookingDetail->rental_price) }}VND</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Form nhập thông tin tài khoản hoàn tiền -->
            <h4 class="font-weight-bold mb-3">Thông tin tài khoản hoàn tiền</h4>
            <form action="{{ route('user.submit_refund_info', $booking->id) }}" method="POST"
                class="bg-white p-4 rounded shadow-sm">
                @csrf
                <div class="form-group">
                    <label for="account_name">Tên tài khoản nhận:</label>
                    <input type="text" class="form-control" id="account_name" name="account_name" required>
                </div>
                <div class="form-group">
                    <label for="account_number">Số tài khoản:</label>
                    <input type="text" class="form-control" id="account_number" name="account_number" required>
                </div>
                <div class="form-group">
                    <label for="bank_name">Ngân hàng:</label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Gửi yêu cầu hoàn tiền</button>
            </form>
        </div>
    </section>
@endsection
