@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Danh sách các đơn đặt xe</h3>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Danh sách đơn đặt xe</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Số điện thoại</th>
                                <th>Tổng tiền</th>
                                <th>Thanh toán</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $booking->user->first_name }} {{ $booking->user->last_name }}</td>
                                    <td>{{ $booking->user->phone_number }}</td>
                                    <td>{{ number_format($booking->total_amount) }} VND</td>
                                    <td>{{ $booking->payment_method }}</td>
                                    <td>{{ $booking->status }}</td>
                                    <td>{{ $booking->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-secondary me-2" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#details-{{ $booking->id }}"
                                                aria-expanded="false" aria-controls="details-{{ $booking->id }}">Xem
                                            </button>
                                            <a href="{{ route('booking.generateInvoice', $booking->id) }}" target="_blank"
                                                class="btn btn-success btn-sm">In</a>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="7" class="p-0">
                                        <div class="collapse" id="details-{{ $booking->id }}">
                                            <div class="p-3 bg-light">
                                                <h5 class="fw-bold">Danh sách xe trong hóa đơn</h5>
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Tên xe</th>
                                                            <th>Giá thuê</th>
                                                            <th>Trạng thái giao xe</th>
                                                            <th>Phương thức</th>
                                                            <th>Hành động</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($booking->booking_detail as $detail)
                                                            <tr>
                                                                <td>{{ $detail->car->name }}</td>
                                                                <td>{{ number_format($detail->rental_price) }} VND</td>
                                                                <td>{{ $detail->pickup_status }}</td>
                                                                <td>{{ $detail->pickup_type }}</td>
                                                                <td>
                                                                    <a href="{{ route('booking.detail', $detail->id) }}"
                                                                        class="btn btn-info btn-sm">Chi tiết</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
