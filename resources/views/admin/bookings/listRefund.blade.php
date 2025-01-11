@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Danh sách các yêu cầu hoàn tiền</h3>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Danh sách yêu cầu hoàn tiền</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên người yêu cầu</th>
                                <th>Số điện thoại</th>
                                <th>Số tiền hoàn</th>
                                <th>Trạng thái</th>
                                <th>Ngày yêu cầu</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listRefund as $refund)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $refund->booking->user->first_name }} {{ $refund->booking->user->last_name }}
                                    </td>
                                    <td>{{ $refund->booking->user->phone_number }}</td>
                                    <td>{{ number_format($refund->refund_amount) }} VND</td>
                                    <td>{{ $refund->status }}</td>
                                    <td>{{ $refund->created_at }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#details-{{ $refund->id }}" aria-expanded="false"
                                            aria-controls="details-{{ $refund->id }}">Xem</button>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="8" class="p-0">
                                        <!-- Phần thông tin chi tiết sẽ hiển thị khi nhấn "Xem" -->
                                        <div class="collapse" id="details-{{ $refund->id }}">
                                            <div class="p-3 bg-light">
                                                <!-- Thêm thông tin chi tiết đơn booking -->
                                                <h5 class="fw-bold mt-4">Thông tin đơn hàng</h5>
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Mã đơn hàng</th>
                                                            <th>Ngày đặt</th>
                                                            <th>Trạng thái đơn</th>
                                                            <th>Phương thức thanh toán</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $refund->booking->id }}</td>
                                                            <td>{{ $refund->booking->created_at->format('d/m/Y H:i') }}
                                                            </td>
                                                            <td>{{ $refund->booking->status }}</td>
                                                            <td>{{ $refund->booking->payment_method }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <h5 class="fw-bold">Chi tiết yêu cầu hoàn tiền</h5>
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Tên tài khoản</th>
                                                            <th>Số tài khoản</th>
                                                            <th>Tên ngân hàng</th>
                                                            <th>Số tiền hoàn</th>
                                                            <th>Trạng thái</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $refund->account_name }}</td>
                                                            <td>{{ $refund->account_number }}</td>
                                                            <td>{{ $refund->bank_name }}</td>
                                                            <td>{{ number_format($refund->refund_amount) }} VND</td>\
                                                            <td>
                                                                <form
                                                                    action="{{ route('refund.updateStatusRefund', $refund->id) }} "method="POST">
                                                                    @csrf
                                                                    <select name="status"
                                                                        class="form-select form-select-sm">
                                                                        <option value="Đã yêu cầu"
                                                                            {{ $refund->status == 'Đã yêu cầu' ? 'selected' : '' }}>
                                                                            Đã yêu cầu
                                                                        </option>
                                                                        <option value="Đã hoàn tiền"
                                                                            {{ $refund->status == 'Đã hoàn tiền' ? 'selected' : '' }}>
                                                                            Đã hoàn tiền
                                                                        </option>
                                                                    </select>
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm mt-2">Cập
                                                                        nhật</button>
                                                                </form>
                                                            </td>
                                                        </tr>
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
