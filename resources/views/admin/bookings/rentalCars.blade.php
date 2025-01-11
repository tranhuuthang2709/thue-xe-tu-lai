@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Danh sách các đơn đặt xe đang được thuê</h3>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Danh sách các đơn đặt xe đang được thuê</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên xe</th>
                                <th>Ảnh</th>
                                <th>Giá</th>
                                <th>Trạng thái xe</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày trả xe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rentedBookings as $booking)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $booking->car->name }}</td>
                                    <td><img src="{{ asset('storage/img_car/' . $booking->car->main_image) }}"
                                            alt="Ảnh sản phẩm" width="50" height="50"></td>
                                    <td>{{ number_format($booking->rental_price) }} VND</td>
                                    <td> {{ $booking->pickup_status }}</td>
                                    <td>{{ $booking->pickup_type === 'Tự đến lấy xe' ? $booking->returnAddress->pickup_time : $booking->pickupAddress->pickup_time }}
                                    </td>
                                    <td>{{ $booking->returnAddress->return_time }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
