@extends('admin.index')

@section('content')
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="fw-bold">Danh sách xe hư hỏng</h3>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Danh sách các đơn hư hỏng</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên xe</th>
                            @can('admin-employee')
                                <th>Người thuê</th>
                                <th>Số điện thoại</th>
                            @endcan
                            <th>Miêu tả hư hỏng</th>
                            <th>Chi phí sửa chữa</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Ngày tạo</th>
                            @can('admin-employee')
                                <th>Hành động</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($damageReports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->bookingDetail->car->name }}</td>
                                @can('admin-employee')
                                    <td>{{ $report->user->first_name }} {{ $report->user->last_name }}</td>
                                    <td>{{ $report->user->phone_number }}</td>
                                @endcan
                                <td>{{ $report->damage_description }}</td>
                                <td>{{ number_format($report->damage_cost) }} VND</td>
                                <td>{{ $report->payment_status }}</td>
                                <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                                @can('admin-employee')
                                    <td>
                                        <!-- Nút cập nhật trạng thái thanh toán -->
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#updatePaymentStatusModal-{{ $report->id }}">
                                            Cập nhật
                                        </button>
                                    </td>
                                @endcan

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Không có xe hư hỏng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Cập nhật trạng thái thanh toán -->
    @foreach ($damageReports as $report)
        <div class="modal fade" id="updatePaymentStatusModal-{{ $report->id }}" tabindex="-1"
            aria-labelledby="updatePaymentStatusModalLabel-{{ $report->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('damageReports.updatePaymentStatus', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="updatePaymentStatusModalLabel-{{ $report->id }}">Cập nhật trạng
                                thái thanh toán</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="payment_status">Trạng thái thanh toán</label>
                                <select class="form-control" id="payment_status" name="payment_status" required>
                                    <option value="Chưa thanh toán"
                                        {{ $report->payment_status == 'Chưa thanh toán' ? 'selected' : '' }}>Chưa thanh
                                        toán</option>
                                    <option value="Đã thanh toán"
                                        {{ $report->payment_status == 'Đã thanh toán' ? 'selected' : '' }}>Đã thanh toán
                                    </option>
                                    <option value="Đang xử lý"
                                        {{ $report->payment_status == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
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
    @endforeach
@endsection
