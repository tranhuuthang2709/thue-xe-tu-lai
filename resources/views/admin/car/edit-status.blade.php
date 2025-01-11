@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Cập nhật trạng thái xe</h3>
            <a href="{{ route('car.index') }}" class="ms-auto text-end btn btn-secondary">Quay lại</a>
        </div>

        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Cập nhật trạng thái xe</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('car.updateStatus', $car->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Tình trạng xe</label>
                            <select name="status" class="form-control">
                                <option value="Có sẵn" {{ old('status', $car->status) == 'Có sẵn' ? 'selected' : '' }}>Có
                                    sẵn</option>
                                <option value="Đang thuê"
                                    {{ old('status', $car->status) == 'Đang thuê' ? 'selected' : '' }}>Đang thuê</option>
                                <option value="Đang bảo trì"
                                    {{ old('status', $car->status) == 'Đang bảo trì' ? 'selected' : '' }}>Đang bảo trì
                                </option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="error-message text-danger">* {{ $errors->first('status') }}</span>
                            @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                            <a href="{{ route('car.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
