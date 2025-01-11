@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Cập nhật trạng thái đơn booking</h3>
            <a href="{{ route('booking.index') }}" class="ms-auto text-end btn btn-secondary">Quay lại</a>
        </div>

        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Cập nhật trạng thái đơn</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Trạng thái đơn -->
                            <div class="col-md-12 form-group mb-3">
                                <label for="status" class="form-label">Trạng thái đơn</label>
                                <select name="status" class="form-control">
                                    <option value="Đang xử lý"
                                        {{ old('status', $booking->status) == 'Đang xử lý' ? 'selected' : '' }}>Đang xử
                                        lý</option>
                                    <option value="Chờ xác nhận"
                                        {{ old('status', $booking->status) == 'Chờ xác nhận' ? 'selected' : '' }}>Chờ xác
                                        nhận</option>
                                    <option value="Đã xác nhận"
                                        {{ old('status', $booking->status) == 'Đã xác nhận' ? 'selected' : '' }}>Đã xác nhận
                                    </option>
                                    <option value="Đang giao"
                                        {{ old('status', $booking->status) == 'Đang giao' ? 'selected' : '' }}>Đang giao
                                    </option>
                                    <option value="Hoàn thành"
                                        {{ old('status', $booking->status) == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành
                                    </option>
                                    <option value="Hủy bỏ"
                                        {{ old('status', $booking->status) == 'Hủy bỏ' ? 'selected' : '' }}>Hủy bỏ</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="error-message text-danger">* {{ $errors->first('status') }}</span>
                                @endif
                            </div>

                            <!-- Nút lưu -->
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-success">Cập nhật</button>
                                <a href="{{ route('booking.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
