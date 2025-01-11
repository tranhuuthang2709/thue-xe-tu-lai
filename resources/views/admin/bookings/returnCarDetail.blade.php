@extends('admin.index')

@section('content')
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="fw-bold">Chi tiết đơn trả xe #{{ $bookingDetail->id }}</h3>
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
                        <h5 class="fw-bold">Trạng thái đơn trả từ khách hàng</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Trạng thái trả xe</th>
                                <td
                                    class="{{ $bookingDetail->return_status == 'Thành công' ? 'text-success' : 'text-danger' }}">
                                    {{ $bookingDetail->return_status }}
                                    @can('admin-employee')
                                        <button class="btn btn-link text-primary" data-bs-toggle="modal"
                                            data-bs-target="#updateStatusModal">
                                            <i class="fas fa-edit"></i> Cập nhật
                                        </button>
                                    @endcan

                                </td>
                            </tr>
                            <tr>
                                <th>Ngày nhận xe</th>
                                <td>
                                    @if ($bookingDetail->pickup_type === 'Tự đến lấy xe')
                                        {{ $bookingDetail->returnAddress->pickup_time }}
                                    @else
                                        {{ $bookingDetail->pickupAddress->pickup_time }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày trả</th>
                                <td>{{ $bookingDetail->returnAddress->return_time }}</td>
                            </tr>
                            <tr>
                                <th>Số ngày thuê</th>
                                <td>{{ $bookingDetail->rental_days }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        @can('admin-employee')
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
                        @endcan
                        <h5 class="fw-bold">Thông tin chủ xe</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Tên chủ xe</th>
                                <td>{{ $bookingDetail->car->user->first_name }} {{ $bookingDetail->car->user->last_name }}
                                </td>
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
                        <h5 class="fw-bold">Thanh toán</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Phương thức</th>
                                <td>{{ $bookingDetail->booking->payment_method }}
                                </td>
                            </tr>
                            <tr>
                                <th>Số tiền</th>
                                <td>{{ $bookingDetail->booking->total_amount }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>{{ $bookingDetail->booking->status }}</td>
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
                            <form action="{{ route('booking.updateReturnStatus', $bookingDetail->id) }}" method="POST">
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
                                            <option value="Thành công">Thành công</option>
                                            <option value="Đang xử lý">Đang xử lý</option>
                                            <option value="Đang kiểm tra">Đang kiểm tra</option>

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
                <div class="row mt-4">
                    <div class="col-md-12 d-flex justify-content-center">
                        <a href="{{ route('booking.index') }}" class="btn btn-secondary me-5 ">Quay lại danh sách</a>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#damageModal{{ $bookingDetail->id }}">
                            Tạo đơn hư hỏng
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal tạo đơn hư hỏng -->
        <div class="modal fade" id="damageModal{{ $bookingDetail->id }}" tabindex="-1"
            aria-labelledby="damageModalLabel{{ $bookingDetail->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('booking.storeDamageReport', $bookingDetail->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="damageModalLabel{{ $bookingDetail->id }}">Tạo đơn hư hỏng cho đơn
                                #{{ $bookingDetail->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="damage_description">Miêu tả hư hỏng</label>
                                <textarea class="form-control" id="damage_description" name="damage_description" rows="4"
                                    placeholder="Miêu tả tình trạng hư hỏng xe" required></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="damage_cost">Chi phí sửa chữa (VND)</label>
                                <input type="number" class="form-control" id="damage_cost" name="damage_cost"
                                    placeholder="Nhập chi phí sửa chữa ">
                            </div>

                            <div class="form-group mt-3">
                                <label for="payment_status">Trạng thái thanh toán</label>
                                <select class="form-control" id="payment_status" name="payment_status" required>
                                    <option value="Đang xử lý">Đang xử lý</option>
                                    <option value="Chưa thanh toán">Chưa thanh toán</option>
                                    <option value="Thành công">Thành công</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu thông tin hư hỏng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
