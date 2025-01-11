@extends('admin.index')

@section('content')
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="fw-bold">Chi tiết đơn đặt xe #{{ $bookingDetail->id }}</h3>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Thông tin chi tiết booking</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Thông tin xe</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Tên xe</th>
                                <td>{{ $bookingDetail->car->name }}</td>
                            </tr>
                            <tr>
                                <th>Giá thuê</th>
                                <td>{{ number_format($bookingDetail->rental_price) }} VND</td>
                            </tr>
                            @if ($bookingDetail->pickup_type === 'Giao xe tận nơi')
                                <tr>
                                    <th>Phí vận chuyển</th>
                                    <td>100,000 VND</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Địa chỉ xe</th>
                                <td>{{ $bookingDetail->car->Address->street }},
                                    {{ $bookingDetail->car->address->ward }},
                                    {{ $bookingDetail->car->Address->district }},
                                    {{ $bookingDetail->car->Address->province }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold">Trạng thái đơn đặt</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Trạng thái giao xe</th>
                                <td
                                    class="{{ $bookingDetail->pickup_status == 'Thành công' ? 'text-success' : 'text-danger' }}">
                                    {{ $bookingDetail->pickup_status }}
                                    <button class="btn btn-link text-primary" data-bs-toggle="modal"
                                        data-bs-target="#updateStatusModal">
                                        <i class="fas fa-edit"></i> Cập nhật
                                    </button>
                                </td>

                            </tr>
                            <tr>
                                <th>Ngày nhận xe</th>
                                <td>

                                    {{ $bookingDetail->pickupAddress->pickup_time }}

                                </td>
                            </tr>
                            <tr>
                                <th>Ngày trả</th>
                                <td>{{ $bookingDetail->returnAddress->return_time }}</td>
                            </tr>
                            <tr>
                                <th>Số ngày thuê</th>
                                <td>
                                    {{ $bookingDetail->rental_days }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Thông tin khách hàng</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Tên khách hàng</th>
                                <td>{{ $bookingDetail->booking->user->first_name }}
                                    {{ $bookingDetail->booking->user->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại</th>
                                <td>{{ $bookingDetail->booking->user->phone_number }}</td>
                            </tr>
                        </table>
                        <h5 class="fw-bold">Thông tin chủ xe</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Tên chủ xe</th>
                                <td>{{ $bookingDetail->car->user->first_name }}
                                    {{ $bookingDetail->car->user->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại</th>
                                <td>{{ $bookingDetail->booking->user->phone_number }}</td>
                            </tr>

                        </table>
                    </div>

                    <div class="col-md-6">
                        <h5 class="fw-bold">Thông tin địa chỉ</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Địa chỉ nhận</th>
                                <td>
                                    @if ($bookingDetail->pickupAddress)
                                        <li>{{ $bookingDetail->pickupAddress->street }},
                                            {{ $bookingDetail->pickupAddress->ward }},
                                            {{ $bookingDetail->pickupAddress->district }},
                                            {{ $bookingDetail->pickupAddress->province }}</li>
                                    @else
                                        <p>Vui lòng chờ nhân viên chọn địa chỉ lấy xe</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Địa chỉ trả</th>
                                <td>
                                    <li>{{ $bookingDetail->returnAddress->street }},
                                        {{ $bookingDetail->returnAddress->ward }},
                                        {{ $bookingDetail->returnAddress->district }},
                                        {{ $bookingDetail->returnAddress->province }}</li>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

                <hr>

                <!-- Modal Update Status -->
                <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('booking.updatePickupStatus', $bookingDetail->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusModalLabel">Cập nhật trạng thái</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="status">Chọn trạng thái</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="Đang xử lý">Đang xử lý</option>
                                            <option value="Đang lấy xe">Đang lấy xe</option>
                                            <option value="Đang giao">Đang giao</option>
                                            <option value="Thành công">Thành công</option>
                                            <option value="Hủy bỏ">Hủy bỏ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="text-center mt-4">
                    <a href="{{ route('booking.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
                </div>
            </div>
        </div>
    </div>
@endsection
